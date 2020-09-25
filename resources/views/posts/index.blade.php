@extends('layouts.app')

@section('content')
<div class="top-wrapper">
  <div class="articles-wrapper col-md-6">
    @foreach ($posts as $post)
    <div class="article-box">
      <div class="article-box-left"></div>
      <div class="article-box-right">
        <a class="article-title" href="/drafts/{{$article->id}}">{{ $post->title }}</a>
        <div class="article-details">
          <div class="article-date">{{ $post->created_at }}</div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection