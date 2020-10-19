<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // values
        $tag_btn_value = $request->input('tag_btn');
        $order = $request->input('order');
        $lgtm_min = $request->input('lgtm-min');
        $lgtm_max = $request->input('lgtm-max');
        $priod = $request->input('priod');
        $priod_start = $request->input('piriod-start');
        $priod_end = $request->input('piriod-end');


        // keyword
        $keyword = $request->input('search');
        $keyword_space_half = mb_convert_kana($keyword, 's');
        $keywords = preg_split('/[\s]+/', $keyword_space_half);
        preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶ亜-熙]+)/u', $keyword, $match);
        $no_tag_keywords = array_diff($keywords, $match[0]);
        $tags = $match[1];
        $tags_count = count($tags);

        // query
        $query = Post::withCount('likes');

        //LGTM sum search
        if ($lgtm_min !== null) {
            $query->having('likes_count', '>=', $lgtm_min);
        }
        if ($lgtm_max !== null) {
            $query->having('likes_count', '<=', $lgtm_max);
        }

        // priod search
        if ($priod !== null) {
            switch ($priod) {
                case "day":
                    $query->where([
                        ['posts.created_at', '>=', date("Y-m-d 00:00:00")],
                        ['posts.created_at', '<=', date("Y-m-d 23:59:59")]
                    ]);
                case "week":
                    $query->where([
                        ['posts.created_at', '>=', date("Y-m-d 00:00:00", strtotime("-1 week"))],
                        ['posts.created_at', '<=', date("Y-m-d 23:59:59")]
                    ]);
                case "month":
                    $query->where([
                        ['posts.created_at', '>=', date("Y-m-d 00:00:00", strtotime("-1 month"))],
                        ['posts.created_at', '<=', date("Y-m-d 23:59:59")]
                    ]);
                case "period":
                    $query->where([
                        ['posts.created_at', '>=', date("{$priod_start} 00:00:00")],
                        ['posts.created_at', '<=', date("{$priod_end} 23:59:59")]
                    ]);
            }
        }

        if ($keyword !== null) {
            // tags search
            if (count($tags) !== 0) {
                $query
                    ->join('post_tags', 'posts.id', '=', 'post_tags.post_id')
                    ->join('tags', 'post_tags.tag_id', '=', 'tags.id')
                    ->whereIn('tags.name', $tags)
                    ->groupBy('posts.id')
                    ->havingRaw('count(distinct tags.id) = ?', [count($tags)]);
            }

            // keywords search
            foreach ($no_tag_keywords as $no_tag_keyword) {
                $query
                    ->where(function ($query) use ($no_tag_keyword) {
                        $query
                            ->where('posts.title', 'like', '%' . $no_tag_keyword . '%')
                            ->orWhere('posts.body', 'LIKE', "%{$no_tag_keyword}%");
                    });
            }
        }


        // search order
        if ($order == 'new') {
            $posts = $query->orderBy('posts.created_at', 'desc')->get();
        } else {
            $posts = $query->orderBy('likes_count', 'desc')->get();
        }

        return view('posts.index', compact('posts', 'keyword', 'tag_btn_value'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (Auth::check()) {
            $params = $request->validate([
                'title' => 'required|max:255',
                'body' => 'required|string',
            ]);

            $params['user_id'] = Auth::id();
            $post = Post::create($params);
            $tags = $request->tags;

            if (count($tags) !== 0) {
                foreach ($tags as $tag_params) {
                    if (!empty($tag_params)) {
                        $tag = Tag::firstOrCreate(['name' => $tag_params]);
                        $post->tags()->attach($tag);
                    }
                };
            }

            return redirect()->route('posts.show', compact('post'));
        } else {
            return back()->with('flash_message', '編集するにはログインする必要があります');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $user = Auth::user();
        if (Auth::check()) {
            $like = DB::table('likes')
                ->where([
                    ['post_id', '=', $post->id],
                    ['user_id', '=', $user->id]
                ])
                ->get();
            return view('posts.show', compact('post', 'like'));
        } else {
            return view('posts.show', compact('post'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $post = Post::find($id);

            if ($user->id === $post->user_id) {
                return view('posts.edit', compact('post'));
            } else {
                return back()->with('flash_message', '投稿者でなければ編集できません');
            }
        } else {
            return back()->with('flash_message', '編集するにはログインする必要があります');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, post $post)
    {

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->id === $post->user_id) {
                $params = $request->validate([
                    'title' => 'required|max:255',
                    'body' => 'required|string',
                ]);

                $post->fill($params)->save();
                $tags = $request->tags;
                $post->tags()->detach();

                if (count($tags) !== 0) {
                    foreach ($tags as $tag_params) {
                        if (!empty($tag_params)) {
                            $tag = Tag::firstOrCreate(['name' => $tag_params]);
                            $post->tags()->attach($tag);
                        }
                    };
                }


                return redirect()->route('posts.show', compact('post'));
            } else {
                return back()->with('flash_message', '投稿者でなければ編集できません');
            }
        } else {
            return back()->with('flash_message', '編集するにはログインする必要があります');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->id === $post->user_id) {

                $post->delete();
                return redirect(route('root'))->with('flash_message', '削除されました');
            } else {
                return back()->with('flash_message', '投稿者でなければ削除できません');
            }
        } else {
            return back()->with('flash_message', '削除するにはログインする必要があります');
        }
    }
}
