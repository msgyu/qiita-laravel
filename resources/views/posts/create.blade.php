@extends('layouts.app')

@section('content')
<form class="post-page-wrapper" action="{{ route('posts.store') }}" method="post">
  @csrf
  <div class="post-create_wrapper">
    <input type="text" class="form-control" id="title-input" placeholder="タイトル" name="title">
    <ul class="tag-wrapper">
      <li class="tag-new">
        <input id="tag-input" name="tags[]" class="tag-input" placeholder="プログラミング技術に関するタグを入力" type="text" />
      </li>
    </ul>
    <div class="markdown-wrapper">
      <div class="markdown">
        <textarea name="body" id="markdown_editor_textarea" placeholder="プログラミング知識をmarkdonw記法で書いて共有" cols="30" rows="10"></textarea>
      </div>
      <div class="markdown">
        <div id="markdown_preview"></div>
      </div>
    </div>
  </div>
  <div class="post-create-footer">
    <button type='submit' class="post-button" tabindex="41">
      <i class="fa fa-upload"></i>
      Oiita に投稿
    </button>
  </div>
</form>
@endsection