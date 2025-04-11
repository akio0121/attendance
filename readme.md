・アプリケーション名
勤怠管理システム

・環境構築

Docker ビルド
1,git@github.com:akio0121/attendance.git
2,DockerDesktop アプリを起動する。
3,docker-compose up -d --build

Laravel 環境構築
1,docker-compose exec php bash
2,composer install
3,「.env.example」ファイルを 「.env」ファイルに命名を変更する。
4,php artisan key:generate
5,php artisan migrate
6,php artisan db:seed

・ダミーデータ
管理者
名前：山田太郎
メールアドレス：aaa@bbb.com
パスワード：aaaaaaaa

一般ユーザー
名前：鈴木一郎
メールアドレス：bbb@ccc.com
パスワード：bbbbbbbb

一般ユーザー
名前：佐藤二郎
メールアドレス：ccc@ddd.com
パスワード：cccccccc

一般ユーザー
名前：田中三郎
メールアドレス：ddd@eee.com
パスワード：dddddddd

・使用技術（実行環境）
PHP 8.3.12
MySQL 8.0.26
Laravel 8.83.8

・ER 図

・URL
開発環境 http://localhost/
phpMyAdmin http://localhost:8080/
