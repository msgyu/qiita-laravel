@foreach ($posts as $post)
<div class="post-box">
  <img class="post-box_left" src="{{ asset('./img/sample-user.png') }}" alt="ロゴ">
  <div class="post-box_right">
    @if (Route::currentRouteName() === 'likes.index')
    <a class="post-title" href="{{ route('posts.show', $post->post_id)}}">{{ $post->title }}</a>
    @else
    <a class="post-title" href="{{ route('posts.show', $post->id)}}">{{ $post->title }}</a>
    @endif
    <div class="post-details">
      <div class="post-details_date">{{ $post->created_at }}</div>
    </div>
  </div>
</div>
@endforeach