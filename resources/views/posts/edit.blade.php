@extends('layouts.app')

@section('content')
<form class="post-page-wrapper" action="{{ route('posts.update', $post) }}" method="post">
  @csrf
  @method('PUT')
  <div class="post-create_wrapper">
    <input type="text" class="form-control" id="title-input" value="{{ $post->title }}" placeholder="タイトル" name="title">
    <ul class="tag-wrapper ">
      @foreach($post->tags as $tag)
      <li class="tag-content">
        <span class="tag-label">
          {{$tag->name}}
        </span>
        <a class="text-icon">
          ×
        </a>
        <input class="tag-hidden-field" name="tags[]" value="{{$tag->name}}" type="hidden">
      </li>
      @endforeach
      <li class="tag-new">
        <input id="tag-input" name="tags[]" class="tag-input" placeholder="プログラミング技術に関するタグを入力" type="text" />
      </li>
    </ul>
    <div class="markdown-wrapper">
      <div class="markdown">
        <textarea name="body" id="markdown_editor_textarea" placeholder="プログラミング知識をmarkdonw記法で書いて共有" cols="30" rows="10">{{ $post->body }}</textarea>
      </div>
      <div class="markdown">
        <div id="markdown_preview"></div>
      </div>
    </div>
  </div>
  <div class="post-create-footer">
    <button type='submit' class="post-button" tabindex="41">
      <i class="fa fa-upload"></i>
      更新する
    </button>
  </div>
</form>
@endsection