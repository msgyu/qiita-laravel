<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
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
        $query = Post::withCount('likes')
            ->join('likes', 'posts.id', '=', 'likes.post_id')
            ->where('likes.user_id', '=', Auth::id());


        //LGTM sum search
        if ($lgtm_min !== null) {
            $query->having('likes_count', '>=', $lgtm_min);
        }
        if ($lgtm_max !== null) {
            $query->having('likes_count', '>=', $lgtm_max);
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
            $like_posts = $query->orderBy('posts.created_at', 'desc')->get();
        } else {
            $like_posts = $query->orderBy('likes_count', 'desc')->get();
        }
        $posts = DB::table('posts')->count();

        return view('likes.index', compact('posts', 'like_posts', 'keyword', 'tag_btn_value'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(like $like)
    {
        //
    }

    public function like_product(Request $request)
    {
        if (Auth::check()) {
            $user = auth()->user();
            if ($request->input('like_exist') == 0) {
                Like::create([
                    'post_id' => $request->input('post_id'),
                    'user_id' => $user->id,
                ]);
            } elseif ($request->input('like_exist')  == 1) {
                Like::where('post_id', "=", $request->input('post_id'))
                    ->where('user_id', "=", $user->id)
                    ->delete();
            }
        }
        return  $request->input('like_exist');
    }
}
