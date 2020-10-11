@extends('layouts.app')

@section('content')
<div class="top-wrapper">
  @include('parts.detaile-search')
  <div class="posts-wrapper col-md-6">
    <div class="posts-nav">
      <ul class="posts-nav_ul">
        <li>
          <a href="{{ route('posts.index') }}">
            すべて
            <span class="badge">{{ $posts }}</span>
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
    @if(count($like_posts) !== 0)
    @include('parts.posts_index', ['posts' => $like_posts] )
    @else
    <p>「{{ $keyword }}」に一致する記事は見つかりませんでした。</p>
    @endif
  </div>
</div>
@endsection