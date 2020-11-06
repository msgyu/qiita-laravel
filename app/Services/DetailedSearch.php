<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DetailedSearch
{
  public static function DetailedSearch($query, $lgtm_min, $lgtm_max, $priod, $priod_start, $priod_end, $keyword, $order)
  {
    $keyword_space_half = mb_convert_kana($keyword, 's');
    $keywords = preg_split('/[\s]+/', $keyword_space_half);
    preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶ亜-熙]+)/u', $keyword, $match);
    $no_tag_keywords = array_diff($keywords, $match[0]);
    $tags = $match[1];

    //LGTM sum search
    if ($lgtm_min !== null) {
      $query->having('likes_count', '>=', $lgtm_min);
    }
    if ($lgtm_max !== null) {
      $query->having('likes_count', '<=', $lgtm_max);
    }

    // priod search
    if ($priod !== null) {
      switch ($priod) {
        case "day":
          $query->where([
            ['posts.created_at', '>=', date("Y-m-d 00:00:00")],
            ['posts.created_at', '<=', date("Y-m-d 23:59:59")]
          ]);
        case "week":
          $query->where([
            ['posts.created_at', '>=', date("Y-m-d 00:00:00", strtotime("-1 week"))],
            ['posts.created_at', '<=', date("Y-m-d 23:59:59")]
          ]);
        case "month":
          $query->where([
            ['posts.created_at', '>=', date("Y-m-d 00:00:00", strtotime("-1 month"))],
            ['posts.created_at', '<=', date("Y-m-d 23:59:59")]
          ]);
        case "period":
          $query->where([
            ['posts.created_at', '>=', date("{$priod_start} 00:00:00")],
            ['posts.created_at', '<=', date("{$priod_end} 23:59:59")]
          ]);
      }
    }

    if ($keyword !== null) {
      // tags search
      if (count($tags) !== 0) {
        $query
          ->join('post_tags', 'posts.id', '=', 'post_tags.post_id')
          ->join('tags', 'post_tags.tag_id', '=', 'tags.id')
          ->whereIn('tags.name', $tags)
          ->groupBy('posts.id')
          ->havingRaw('count(distinct tags.id) = ?', [count($tags)]);
      }

      // keywords search
      foreach ($no_tag_keywords as $no_tag_keyword) {
        $query
          ->where(function ($query) use ($no_tag_keyword) {
            $query
              ->where('posts.title', 'like', '%' . $no_tag_keyword . '%')
              ->orWhere('posts.body', 'LIKE', "%{$no_tag_keyword}%");
          });
      }
    }


    // search order
    if ($order == 'new') {
      $posts = $query->orderBy('posts.created_at', 'desc')->paginate(20);
    } else {
      $posts = $query->orderBy('likes_count', 'desc')->paginate(20);
    }
    return $posts;
  }
}
