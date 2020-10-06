@extends('layouts.app')

@section('content')
<div class="post-page-wrapper">
  <div class="post-wrapper">
    <div class="post-header">
      <ul class="post-header_ul-left">
        <li><img class="user-icon" width="32px" height="32px" src="{{ asset('./img/sample-user.png') }}" alt="ロゴ"></li>
        <li class="user-name">{{ $post->user->name }}</li>
        <li class="date">{{ $post->created_at }}</li>
      </ul>
      <ul class="post-header_ul-right">
        @if (Auth::check())
        @if($post->user_id === Auth::user()->id)
        <li>
          <a href="{{ route('posts.edit', $post->id) }}" class="edit-pass">
            <span>
              <i class="fas fa-pencil-alt"></i>
              編集する
            </span>
          </a>
        </li>
        <li>
          <div class="dropdown show">
            <a class="dropdown-toggle setting" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span><i class="fas fa-cog"></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
              <form class="dropdown-item trash-form" style="display: inline-block;" method="POST" action="{{ route('posts.destroy', $post) }}">
                @csrf
                @method('DELETE')

                <button>
                  <span class="trash-form_btn"><i class="far fa-trash-alt "></i></span>
                  <span>削除</span>
                </button>
              </form>
            </div>
          </div>
        </li>
        @endif
        @endif
      </ul>
    </div>
    <div class="post-title"> {{ $post->title }}</div>
    @if($post->tags)
    <div class="post-tags" style="display:inline-flex">
      @foreach ($post->tags as $tag)
      <div>
        <form action="{{ route('posts.index')}}" method="GET">
          <button class="post-tag" name="tag_btn" value="{{ optional($tag)->name }}">{{ optional($tag)->name }}</button>
        </form>
      </div>
      @endforeach
    </div>
    @endif
    @auth
    <div class="btn-warapper">
      @if($like)
      <div class="like">
        <button class="like_btn" post_id="{{ $post->id }}" like_exist="1" style="color:#fff; background: #55c500">LGTM</button>
      </div>
      @else
      <div class="like">
        <button class="like_btn" post_id="{{ $post->id }}" like_exist="0">LGTM</button>
      </div>
      @endif
    </div>
    @endauth
    <div class="post-body">{{$post->body}}</div>
  </div>
</div>
@endsection