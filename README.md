# coachtechフリマ

## 環境構築

### Docker環境構築(ビルド)
1. `git clone https://github.com/Roba-97/ObanaRyota-mockcase1-furima-app.git`
2. Docker Desctop アプリを起動して `docker-compose up -d --build`

### Laravel環境構築
1. `docker-compose exec php bash`
2. `composer install`
3. .env.exampleをコピーして「.env」ファイルを作成し以下の環境変数を設定
``` copy
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
4. `php artisan key:generate`
5. `php artisan migrate --seed`

### Mailhog接続設定
.env ファイルに以下の環境変数を追加
``` copy
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS={Any_email_address}
MAIL_FROM_NAME="${APP_NAME}"
```

### Stripe接続設定
.env ファイルに以下の環境変数を追加
``` copy
STRIPE_KEY={Your_Public_API_Key}
STRIPE_SECRET={Your_Secret_API_Key}
```
Stripeアカウントを作成されてない方は、[Stripeトップページ](https://stripe.com/jp) から


## アプリケーションの動作確認について
テスト用のユーザが TestUserSeeder.php によって作成されます（DatabaseSeeder.phpに登録済み）<br>
以下のアカウント情報でログインしてください
| 入力欄| 入力内容 |
| --- | --- |
| メールアドレス | `test@example.com` |
| パスワード| `password` |

このテスト用ユーザでは、出品、購入、お気に入り登録した商品が確認できます


## テストの実行について
Laravel Dusk を用いてテストを作成しています。以下のコマンドで実行してください。<br>
`php artisan dusk test/Browser/テストファイル名`<br>
テスト実行後は、以下のコマンドで再度マイグレーションを行ってください。<br>
`php artisan migrate:fresh --seed`


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
