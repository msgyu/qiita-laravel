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
    public function top()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.top', compact('posts'));
    }

    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $tag_btn_value = $request->input('tag_btn');


        if ($keyword !== null) {
            $keyword_space_half = mb_convert_kana($keyword, 's');
            $keywords = preg_split('/[\s]+/', $keyword_space_half);
            preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶ亜-熙]+)/u', $keyword, $match);
            $no_tag_keywords = array_diff($keywords, $match[0]);
            $tags = $match[1];

            $query = DB::table('posts');
            if (count($tags) !== 0) {
                $query
                    ->join('post_tags', 'posts.id', '=', 'post_tags.post_id')
                    ->join('tags', 'post_tags.tag_id', '=', 'tags.id')
                    ->whereIn('tags.name', $tags)
                    ->groupBy('posts.id');
                // ->having(count('posts.id'), '=', [count($mtags)])
            }

            foreach ($no_tag_keywords as $keyword) {
                $query
                    ->where('posts.title', 'like', '%' . $keyword . '%')
                    ->orWhere('posts.body', 'LIKE', "%{$keyword}%");
            }
            $posts = $query->orderBy('posts.created_at', 'desc')->get();
        } elseif ($tag_btn_value !== null) {
            $tag = Tag::firstOrCreate(['name' => $tag_btn_value]);
            $posts = $tag->posts;
        } else {
            $posts = Post::orderBy('created_at', 'desc')->get();
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
        return view('posts.show', compact('post'));
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
