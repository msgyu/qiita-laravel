@extends('layouts.app')

@section('content')
<div class="post-page-wrapper">
  <div class="post-wrapper">
    <div class="post-header">
      <ul class="post-header_info">
        <li><img class="user-icon" width="32px" height="32px" src="{{ asset('./img/sample-user.png') }}" alt="ロゴ"></li>
        <li class="user-name">{{ $post->user->name }}</li>
        <li class="date">{{ $post->created_at }}</li>
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