# coachtechフリマ

## 環境構築

### Docker環境構築(ビルド)
1. git clone https://github.com/Roba-97/ObanaRyota-mockcase1-furima-app.git
2. docker-compose up -d --build

### Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. .env.exampleをコピーし.envファイルを作成、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed

### Mailhog接続設定
.env ファイルに以下の環境変数を追加（.env.exampleをコピーした場合は設定済みであることを確認してください）

### Stripe接続設定
.env ファイルに以下の環境変数を追加


## テストの実行について
Laravel Dusk を用いてテストを作成しています。以下のコマンドで実行してください。 



## 使用技術
- PHP 7.4.9
- Laravel Framework 8.83.8
- mysql:8.0.26
- nginx:1.21.1
- mailhog:latest
- selenium standalone-chrome-debug:latest

## ER図
![ER図](/src/er-diagram.drawio.png)

## URL
- 開発環境 : [http://localhost/](http://localhost/ )
- phpMyAdmin : [http://localhost:8080/](http://localhost:8080/)
- MailHog : [http://localhost:8025/](http://localhost:8025/)
