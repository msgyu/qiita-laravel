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
    @include('parts.posts_index')
    @else
    <p>「{{ $keyword }}」に一致する記事は見つかりませんでした。</p>
    @endif
  </div>
</div>
@endsection