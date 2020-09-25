@extends('layouts.app')

@section('content')
<form class="post-page-wrapper" action="{{ route('posts.store') }}" method="post">
  @csrf
  <input type="text" class="form-control" id="title-input" placeholder="タイトル" name="title">
  <ul class="tag-wrapper ">
    <li class="tag-new">
      <input id="tag-input" name="tags[]" class="tag-input" placeholder="プログラミング技術に関するタグを入力" type="text" />
    </li>
  </ul>
  <div class="row">
    <div class="col-6">
      <textarea name="body" id="markdown_editor_textarea" placeholder="プログラミング知識をmarkdonw記法で書いて共有" cols="30" rows="10" class="form-control"></textarea>
    </div>
    <div class="col-6">
      <div id="markdown_preview"></div>
    </div>
  </div>
  <div class="post-page-footer">
    <button type='submit' class="post-button m-1" tabindex="41">
      <i class="fa fa-upload"></i>
      Qiita に投稿
    </button>
  </div>
</form>
@endsection