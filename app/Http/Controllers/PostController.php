<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\DetailedSearch;

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
        $all_posts_count = DB::table('posts')->count();

        //settion
        $request->session()->put('order', $request->input('order'));
        $request->session()->put('lgtm-min', $request->input('lgtm-min'));
        $request->session()->put('lgtm-max', $request->input('lgtm-max'));
        $request->session()->put('priod', $request->input('priod'));

        // keyword
        $keyword = $request->input('search');
        if ($tag_btn_value !== null) {
            $keyword = "#{$tag_btn_value}";
        }

        // query
        $query = Post::withCount('likes');
        $posts = DetailedSearch::DetailedSearch($query, $lgtm_min, $lgtm_max, $priod, $priod_start, $priod_end, $keyword, $order);
        return view('posts.index', compact('all_posts_count', 'posts', 'keyword', 'order', 'lgtm_min', 'lgtm_max', 'priod', 'priod_start', 'priod_end', 'tag_btn_value'));
    }

    public function my_posts(Request $request)
    {
        // values
        $tag_btn_value = $request->input('tag_btn');
        $order = $request->input('order');
        $lgtm_min = $request->input('lgtm-min');
        $lgtm_max = $request->input('lgtm-max');
        $priod = $request->input('priod');
        $priod_start = $request->input('piriod-start');
        $priod_end = $request->input('piriod-end');
        $all_posts_count = DB::table('posts')->count();


        // keyword
        $keyword = $request->input('search');
        if ($tag_btn_value !== null) {
            $keyword = "#{$tag_btn_value}";
        }


        // query
        $query = Post::where("posts.user_id", "=", Auth::user()->id)->withCount('likes');
        $posts = DetailedSearch::DetailedSearch($query, $lgtm_min, $lgtm_max, $priod, $priod_start, $priod_end, $keyword, $order);
        return view('posts.my_posts', compact('posts', 'all_posts_count', 'keyword', 'order', 'lgtm_min', 'lgtm_max', 'priod', 'priod_start', 'priod_end', 'tag_btn_value'));
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

            return redirect()->route('posts.show', compact('post'))->with('flash_message', '投稿しました');
        } else {
            return back()->with('flash_message', '投稿するにはログインする必要があります');
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


                return redirect()->route('posts.show', compact('post'))->with('flash_message', '更新しました');
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
            if ($post->exists()) {
                $user = Auth::user();

                if ($user->id === $post->user_id) {

                    $post->delete();
                    return redirect(route('root'))->with('flash_message', '削除されました');
                } else {
                    return back()->with('flash_message', '投稿者でなければ削除できません');
                }
            } else {
                return redirect(route('root'))->with('flash_message', 'すでに存在しません');
            }
        } else {
            return back()->with('flash_message', '削除するにはログインする必要があります');
        }
    }
}
