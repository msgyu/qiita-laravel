@extends('layouts.app')

@section('content')
@if(!Auth::check())
<div id="login-wrapper" class="row">
  <div class="col-7">
    <h1 class="top-heading text-white"><b>How developers code is here.</b></h1>
    <p class="top-heading_text text-white">Oiitaは、エンジニアリングに関する知識を記録・共有するためのサービスです。コードを書いていて気づいたことや、自分がハマったあの仕様について、他のエンジニアと知見を共有しましょう ;)</p>
  </div>
  <div class="col-5">
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <table>
        <tr>
          <th>ユーザ名</th>
          <td><input type="text" class="form-control" placeholder="Oiita" size="50" value="{{ old('email') }}" name="username" required autofocus></td>
        </tr>
        <tr>
          <th>メールアドレス</th>
          <td><input type="email" class="form-control" placeholder="oiita@oiita.com" size="50" name="email" required></td>
        </tr>
        <tr>
          <th>パスワード</th>
          <td><input type="password" class="form-control" name="password" required size="50"></td>
        </tr>
        <tr>
          <th></th>
          <td><input type="submit" value="ログイン" class="form-control"></td>
        </tr>
      </table>
    </form>
  </div>
</div>
@else
@endif
<div class="top-wrapper">
  <div class="posts-wrapper col-md-6">
    @foreach ($posts as $post)
    <div class="post-box">
      <img class="post-box_left" src="{{ asset('./img/sample-user.png') }}" alt="ロゴ">
      <div class="post-box_right">
        <a class="post-title" href="{{ route('posts.show', $post->id)}}">{{ $post->title }}</a>
        <div class="post-details">
          <div class="post-details_date">{{ $post->created_at }}</div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection