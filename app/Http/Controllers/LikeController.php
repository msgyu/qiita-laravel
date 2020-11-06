<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\like;
use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\DetailedSearch;

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
        if ($tag_btn_value !== null) {
            $keyword = "#{$tag_btn_value}";
        }

        // query
        $query = Post::withCount('likes')
            ->join('likes', 'posts.id', '=', 'likes.post_id')
            ->where('likes.user_id', '=', Auth::id());
        $posts = DetailedSearch::DetailedSearch($query, $lgtm_min, $lgtm_max, $priod, $priod_start, $priod_end, $keyword, $order);
        $all_posts_count = DB::table('posts')->count();

        return view('likes.index', compact('posts', 'all_posts_count', 'keyword', 'order', 'lgtm_min', 'lgtm_max', 'priod', 'priod_start', 'priod_end', 'tag_btn_value'));
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
