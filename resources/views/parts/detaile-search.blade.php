<div class="detailed-search col-md-3">
  @if (Route::currentRouteName() === 'likes.index')
  <form action="{{ route('likes.index')}}" method="GET" name="detailed-search_form" class="detailed-search_form">
    @else
    <form action="{{ route('posts.index')}}" method="GET" name="detailed-search_form" class="detailed-search_form">
      @endif
      <div class="detailed-search_form_head">記事の条件</div>
      <div class="detailed-search_form_body">
        <div class="search-conditions keyword-terms">
          <div>
            <span class="search-conditions_title keyword-terms_title">キーワード</span>
          </div>
          <div class="search-warapper">
            <div class="form-inline search-form">
              <i class="fas fa-search"></i>
              @if(isset($keyword))
              <input type="search" name="search" value="{{$keyword}}" class="search-input" placeholder="キーワードを入力" aria-label="検索...">
              @else
              <input type="search" name="search" placeholder="キーワードを入力" class="search-input" aria-label="検索...">
              @endif
            </div>
          </div>
        </div>
        <div class="search-conditions order-terms">
          <div>
            <span class="search-conditions_title order-terms_title">順番</span>
          </div>
          @if($order == "new")
          <div class="search-conditions_radio">
            <input type="radio" name="order" value="lgtm">LGTM数順
          </div>
          <div class="search-conditions_radio">
            <input type="radio" name="order" value="new" checked="checked">新着順
          </div>
          @else
          <div class="search-conditions_radio">
            <input type="radio" name="order" value="lgtm" checked="checked">LGTM数順
          </div>
          <div class="search-conditions_radio">
            <input type="radio" name="order" value="new">新着順
          </div>
          @endif
        </div>
        <div class="search-conditions date-terms">
          <div>
            <span class="search-conditions_title">期間</span>
          </div>
          <div class="search-conditions_radio">
            @if($priod == "day")
            <input type="radio" name="priod" value="day" checked="checked">1日
            @else
            <input type="radio" name="priod" value="day">1日
            @endif
          </div>
          <div class="search-conditions_radio">
            @if($priod == "week")
            <input type="radio" name="priod" value="week" checked="checked">1週間
            @else
            <input type="radio" name="priod" value="week">1週間
            @endif
          </div>
          <div class="search-conditions_radio">
            @if($priod == "month")
            <input type="radio" name="priod" value="month" checked="checked">1月間
            @else
            <input type="radio" name="priod" value="month">1月間
            @endif
          </div>
          <div class="search-conditions_radio">
            @if($priod == "period")
            <input type="radio" name="priod" value="period" checked="checked">期間指定
            @else
            <input type="radio" name="priod" value="period">期間指定
            @endif
          </div>
          <div class="search-conditions_radio">
            <span>
              <label for="">
                開始:<input type="date" class="input-small" name="piriod-start" placeholder="2020-01-11">
              </label>
            </span>
            <span>
              <label for="">
                終了:<input type="date" class="input-small" name="piriod-end" placeholder="2020-02-11">
              </label>
            </span>
          </div>
        </div>
        <div class="search-conditions lgtm-terms">
          <div>
            <span class="search-conditions_title lgtm-terms_title">LGTM</span>
          </div>
          <div class="search-conditions_radio">
            <span>
              <label for="">
                最低:<input type="number" class="input-small" name="lgtm-min" placeholder="100">
              </label>
            </span>
            <span>
              <label for="">
                最高:<input type="number" class="input-small" name="lgtm-max" placeholder="1000">
              </label>
            </span>
          </div>
        </div>
      </div>
    </form>
</div>