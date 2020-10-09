<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\like;
use App\Models\post;
use App\Models\Tag;
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
        $keyword = $request->input('search');
        $tag_btn_value = $request->input('tag_btn');
        $query = DB::table('posts')
            ->join('likes', 'posts.id', '=', 'likes.post_id')
            ->where('likes.user_id', '=', Auth::id());

        if ($keyword !== null) {
            $keyword_space_half = mb_convert_kana($keyword, 's');
            $keywords = preg_split('/[\s]+/', $keyword_space_half);
            preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶ亜-熙]+)/u', $keyword, $match);
            $no_tag_keywords = array_diff($keywords, $match[0]);
            $tags = $match[1];
            $tags_count = count($tags);


            // $query = User::with(['likes.post'])->find(Auth::id())->likes()->post();
            // if (count($tags) !== 0) {
            //     $query
            //         ->join('post_tags', 'posts.id', '=', 'post_tags.post_id')
            //         ->join('tags', 'post_tags.tag_id', '=', 'tags.id')
            //         ->whereIn('tags.name', $tags)
            //         ->groupBy('posts.id')
            //         ->havingRaw('count(distinct tags.id) = ?', [count($tags)]);
            // }

            // foreach ($no_tag_keywords as $keyword) {
            //     $query
            //         ->where('posts.title', 'like', '%' . $keyword . '%')
            //         ->orWhere('posts.body', 'LIKE', "%{$keyword}%");
            // }
            $posts = $query->orderBy('posts.created_at', 'desc')->get();
        } else {
            $posts = Post::orderBy('created_at', 'desc')->get();
        }



        return view('likes.index', compact('posts', 'keyword', 'tag_btn_value'));
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
