![oiita](https://user-images.githubusercontent.com/52862370/96419448-1f21be00-122f-11eb-983f-febc58f61fc2.png)
<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>



# Introduction
Oiitaは「Qiita」に影響を受けたプロジェクトになります。一番の違いは絞り込み検索の充実です。
Qiitaはキーワードでの検索が可能でありながら、複数タグでの検索やLGTM数、期間指定などができません。そのため、欲している記事が見つけにくい問題があります。そこで今回のOiitaでは、絞り込み検索の充実し、目的としている記事をみつけやすいように改善しました。

Oiita will be a project inspired by "Qiita". The biggest difference is the ability to refine the search.
While Qiita allows you to search by keywords, it does not allow you to search by multiple tags, number of LGTMs, or time period. So it can be difficult to find the articles you are looking for. So, we have improved the search function in Oiita to make it easier to find the articles you are looking for.


# function
ここではOiitaの機能紹介をしていきます。

- 記事一覧の表示
- キーワード検索機能（header)
    - 複数キーワード検索
    - 複数タグ検索
- 絞り込み検索(side)
    - 複数キーワード検索
    - 複数タグ検索
    - 順番（新規投稿順、LGTM数順）
    - 投稿期間の指定（本日、１週間、1ヶ月間、開始日〜終了日の指定）
    - LGTM数の指定（最低数、最高数）
    - 記事全体で検索、LGTMした記事で検索
- User認証
- 記事投稿
    - 新規作成(Markdown記法)
    - 編集
    - 削除
- いいね機能 like button




I will introduce the features of Oiita here.

- list of articles
- Keyword search(header)
- conditional search
    - Multiple keyword search
    - Multiple Tag Search
    - Order (in order of new submissions or sum of LGTMs)
    - period specified (today, week, month, start to end date)
    - Specify the range of the number of LGMTs( min and max )
    - Search the entire article or search by LGTMed article
- User auth
- Article Submission
    - Create New (Markdown)
    - Edit
    - Delete
- like button



## 記事一覧の表示（list of articles）
![Oiita記事一覧表示](https://user-images.githubusercontent.com/52862370/96440317-c4925d00-1242-11eb-8980-e3fff69cd088.gif)
記事一覧を表示するトップページ。「すべて」をクリック時は、すべての記事が表示される。ログイン時には「LGTM済み」の選択肢も追加され、LGTM（いいね）した記事の一覧も表示が可能。影響を受けた「Qiita」では「LGTM」と「ストック」の二つの機能に別れているが、別々にする必要性がないため「Oiita」では「LGTM」のみとなっている。また、後述する検索機能を活用すれば、検索結果を絞り込むことができる。

Top page to display a list of articles. When you click on "All", all articles are displayed. When you log in, the "LGTMed" option has been added and the list of LGTM (Liked) articles can be viewed. In the affected "Qiita" it is split into two functions, "LGTM" and "Stock", but in "Oiita" it is only "LGTM" as there is no need to separate them. In addition, the search function, described below, can be used to narrow down the search results.


## キーワード検索機能（header) Keyword search(header)
 

![oiita2](https://user-images.githubusercontent.com/52862370/96419552-44163100-122f-11eb-9a81-33e7fe507a39.png)
![oiita3](https://user-images.githubusercontent.com/52862370/96419584-4d070280-122f-11eb-89ae-f5304d2cf3c3.png)
![ER図](https://user-images.githubusercontent.com/52862370/96422391-ec79c480-1232-11eb-9c29-201200699e9a.png)






## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
