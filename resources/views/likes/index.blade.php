@extends('layouts.app')

@section('content')
<div class="top-wrapper">
  <div class="posts-wrapper col-md-6">
    <div class="posts-nav">
      <ul class="posts-nav_ul">
        <li>
          <a href="{{ route('posts.index') }}">
            すべて
            <span class="badge">{{ count($posts)}}</span>
          </a>
        </li>
        @auth
        <li class="active">
          <a href="">
            LGTM済み
            <span class="badge">{{ count(Auth::user()->likes)}}</span>
          </a>
        </li>
        @endauth
      </ul>
    </div>
    @if(count($posts) !== 0)
    @foreach ($posts as $post)
    <div class="post-box">
      <img class="post-box_left" src="{{ asset('./img/sample-user.png') }}" alt="ロゴ">
      <div class="post-box_right">
        <a class="post-title" href="{{ route('posts.show', $post->post_id)}}">{{ $post->title }}</a>
        <div class="post-details">
          <div class="post-details_date">{{ $post->created_at }}</div>
        </div>
      </div>
    </div>
    @endforeach
    @else
    <p>「{{ $keyword }}」に一致する記事は見つかりませんでした。</p>
    @endif
  </div>
</div>
@endsection