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
          <a href="" class="edit-pass">
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
              <a class="dropdown-item" href="#">
                <span class="trash"><i class="far fa-trash-alt "></i></span>
                <span>削除</span>
              </a>
            </div>
          </div>
        </li>
        @endif
        @endif
      </ul>
    </div>
    <div class="post-title"> {{ $post->title }}</div>
    @if($post->tags)
    <div class="post-tags">
      @foreach ($post->tags as $tag)
      <div class="post-tag">{{ optional($tag)->name }}</div>
      @endforeach
    </div>
    @endif
    <div class="post-body">{{$post->body}}</div>
  </div>
</div>
@endsection