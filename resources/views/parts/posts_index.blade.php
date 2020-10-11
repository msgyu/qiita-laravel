@foreach ($posts as $post)
<div class="post-box">
  <img class="post-box_left" src="{{ asset('./img/sample-user.png') }}" alt="ロゴ">
  <div class="post-box_right">
    <a class="post-title" href="{{ route('posts.show', $post->id)}}">{{ $post->title }}</a>
    <div class="post-details">
      <div class="post-details_date">
        <span>{{ $post->created_at }}</span>
        <span class="lgtm">LGTM {{ count($post->likes) }}</span>
      </div>
    </div>
  </div>
</div>
@endforeach