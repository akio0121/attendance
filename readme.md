# 勤怠管理システム

## 環境構築

#### Docker ビルド
1. `$ git clone git@github.com:akio0121/attendance.git`
2. DockerDesktop アプリを起動する。
3. `$ docker-compose up -d --build`

#### Laravel 環境構築
```bash
$ docker-compose exec php bash
$ composer install
```
`.env.example`ファイルを `.env`ファイルに命名を変更する。
```bash
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed
```

#### ダミーデータ

|役割|名前|メールアドレス|パスワード|
|---|---|---|---|
|管理者|山田太郎|aaa@bbb.com|aaaaaaaa|
|一般ユーザー|鈴木一郎|bbb@ccc.com|bbbbbbbb|
|一般ユーザー|佐藤二郎|ccc@ddd.com|cccccccc|
|一般ユーザー|田中三郎|ddd@eee.com|dddddddd|


## 使用技術（実行環境）
- PHP 8.3.12
- MySQL 8.0.26
- Laravel 8.83.8

### ER 図
![ER図](./ER.png)

### URL
- 開発環境 http://localhost/
- phpMyAdmin http://localhost:8080/
- MailHog http://localhost:8025/
