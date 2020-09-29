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
        $keyword = $request->input('search');
        if ($keyword !== null) {
            $keyword_space_half = mb_convert_kana($keyword, 's');
            $keywords = preg_split('/[\s]+/', $keyword_space_half);

            $query = DB::table('posts');

            foreach ($keywords as $keywords) {
                $query
                    ->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('body', 'LIKE', "%{$keyword}%");
            }
            $posts = $query->select('id', 'title', 'body', 'user_id', 'created_at')->orderBy('created_at', 'desc')->get();
        } else {
            $posts = Post::orderBy('created_at', 'desc')->get();
        }

        if (Auth::check()) {
            return view('posts.index', compact('posts'));
        } else {
            return view('posts.top', compact('posts'));
        }
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
        $params = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|string',
        ]);

        $params['user_id'] = Auth::id();
        $post = Post::create($params);
        $tags = $request->tags;

        foreach ($tags as $tag_params) {
            if (!empty($tag_params)) {
                $tag = Tag::firstOrCreate(['name' => $tag_params]);
                $post->tags()->attach($tag);
            }
        };

        return redirect()->route('posts.show', compact('post'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        //
    }
}
