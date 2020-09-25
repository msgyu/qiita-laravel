@extends('layouts.app')

@section('content')
<div class="post-page-wrapper">
  <div class="post-wrapper">
    <div class="post-header">
      <div class="date">{{ $post->created_at }}</div>
    </div>
    <div class="post-title"> {{ $post->title }}</div>
    @if($post->tags())
    @foreach ($post->tags() as $tag)
    <div class="post-tag">{{$tag}}</div>
    @endforeach
    @endif
    <div class="post-body">{{$post->body}}</div>
  </div>
</div>
@endsection