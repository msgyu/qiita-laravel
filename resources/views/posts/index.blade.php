@extends('layouts.app')

@section('content')
<div class="top-wrapper">
  <div class="posts-wrapper col-md-6">
    <div>
      <ul class="post-nav">
        <li>
          <a href="">すべて</a>
        </li>
        <li>
          <a href="">LGTM済み</a>
        </li>
      </ul>
    </div>
    @if(count($posts) !== 0)
    @foreach ($posts as $post)
    <div class="post-box">
      <img class="post-box_left" src="{{ asset('./img/sample-user.png') }}" alt="ロゴ">
      <div class="post-box_right">
        <a class="post-title" href="{{ route('posts.show', $post->id)}}">{{ $post->title }}</a>
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