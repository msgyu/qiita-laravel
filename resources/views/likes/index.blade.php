@extends('layouts.app')

@section('content')
<div class="top-wrapper">
  <div class="detailed-search col-md-3">
    <form action="" class="detailed-search_form">
      <div class="detailed-search_form_head">記事の条件</div>
      <div class="detailed-search_form_body">
        <div class="search-conditions date-terms">
          <span class="search-conditions_title">日付</span>
          <div class="search-conditions_radio">
            <input type="radio" name="date-terms" value="day">1日
            <input type="radio" name="date-terms" value="week">1週間
            <input type="radio" name="date-terms" value="month">月間
            <input type="radio" name="date-terms" value="period">期間指定
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="posts-wrapper col-md-5">
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