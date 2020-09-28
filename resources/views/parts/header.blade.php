<nav class="navbar navbar-expand-md navbar-light header">
  <div class="header-container">
    <ul class="header-left">
      <li>
        <a class="header-icon" href="{{ url('/') }}">
          {{ config('app.name', 'Laravel') }}
        </a>
      </li>
      <li>
        <div class="header-community">
          <a href="#" class="nav-link dropdown-toggle text-white" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">コミュニティ</a>
        </div>
      </li>
      <li>
        <div class="search-warapper">
          <form class="form-inline my-2 my-lg-0 ml-2 search-form" method="POST" action="{{ route(posts.index )}}">
            <i class="fas fa-search"></i>
            <input type="search" name="search" class="mr-sm-2" placeholder="キーワードを入力" aria-label="検索...">
          </form>
        </div>
      </li>
    </ul>
    <ul class="header-right">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          @guest
          @if (Route::has('register'))
          <li class="nav-item">
            <a class="registar-btn" href="{{ route('register') }}">{{ __('ユーザー登録') }}</a>
          </li>
          <li class="nav-item">
            <a class="" href="{{ route('login') }}">{{ __('ログイン') }}</a>
          </li>
          @endif
          @else
          <li class="nav-item li-icon">
            <a class="nav-link text-white" href="#"></a>
            <i class="fab fa-get-pocket"></i>
            <p class="">ストック一覧</p>
          </li>
          <li>
            <div class="new-post-btn">
              <ul class="new-post-btn_ul">
                <li class="new-post-btn_ul_li">
                  <i class="far fa-edit"></i>
                </li>
                <li class="new-post-btn_ul_li">
                  <p class="">投稿する</p>
                </li>
              </ul>
              <a class="nav-link text-white" id="post-link" href="{{ route('posts.create')}}"></a>
            </div>
          </li>
          <li class=" ml-2 li-icon">
            <a class="nav-link text-white" href="#"></a>
            <i class="far fa-bell"></i>
            <p class="">0</p>
          </li>
          <li class="nav-item dropdown">
            <img class="user-icon" src="{{ asset('./img/sample-user.png') }}" alt="ロゴ">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              <span class="caret"></span>
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">マイページ</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">下書き一覧</a>
              <a class="dropdown-item" href="#">編集リクエスト一覧</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">設定</a>
              <a class="dropdown-item" href="#">ヘルプ</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                {{ __('ログアウト') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
          @endguest
        </ul>
      </div>
    </ul>
  </div>
</nav>