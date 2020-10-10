@extends('layouts.app')

@section('content')
<div class="top-wrapper">
  <div class="detailed-search col-md-3">
    <form action="" class="detailed-search_form">
      <div class="detailed-search_form_head">記事の条件</div>
      <div class="detailed-search_form_body">
        <div class="search-conditions order-terms">
          <div>
            <span class="search-conditions_title order-terms_title">順番</span>
          </div>
          <div class="search-conditions_radio">
            <input type="radio" name="order-terms" value="day" class="">LGTM数順
          </div>
          <div class="search-conditions_radio">
            <input type="radio" name="order-terms" value="week">新着順
          </div>
        </div>
        <div class="search-conditions date-terms">
          <div>
            <span class="search-conditions_title">日付</span>
          </div>
          <div class="search-conditions_radio">
            <input type="radio" name="date-terms" value="day" class="">1日
          </div>
          <div class="search-conditions_radio">
            <input type="radio" name="date-terms" value="week">1週間
          </div>
          <div class="search-conditions_radio">
            <input type="radio" name="date-terms" value="month">月間
          </div>
          <div class="search-conditions_radio">
            <input type="radio" name="date-terms" value="period">期間指定
          </div>
          <div class="search-conditions_radio">
            <span>
              <label for="">
                開始:<input type="date" class="input-small" value="2020-01-11" placeholder="開始">
              </label>
            </span>
            <span>
              <label for="">
                終了:<input type="date" class="input-small" value="2020-01-11" placeholder="終了">
              </label>
            </span>
          </div>
        </div>
        <div class="search-conditions lgtm-terms">
          <div>
            <span class="search-conditions_title lgtm-terms_title">LGTM</span>
          </div>
          <div class="search-conditions_radio">
            <span>
              <label for="">
                最低:<input type="number" class="input-small" value="2020-01-11" placeholder="以上">
              </label>
            </span>
            <span>
              <label for="">
                最高:<input type="number" class="input-small" placeholder="以下">
              </label>
            </span>
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