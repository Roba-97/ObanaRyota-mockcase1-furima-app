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
6. `php artisan storage:link`

### Mailhog接続設定
.env ファイルに以下の環境変数があることを確認（ない場合は追加）
``` copy
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=Laravel@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Stripe接続設定
.env ファイルに以下の環境変数を追加
``` copy
STRIPE_KEY={Your_Public_API_Key}
STRIPE_SECRET={Your_Secret_API_Key}
```
Stripe API Keyは、[Stripeトップページ](https://stripe.com/jp) からアカウントを作成して取得してください


## アプリケーションの動作確認について

### 開発環境アクセス時のエラーについて
「The stream or file "/var/www/storage/logs/laravel.log" could not be opened in append mode　･･･」<br>
開発環境にアクセスした際に、上記のエラーが表示された場合は以下のコマンドで権限変更を行ってください<br>
`chmod 777 -R src *`<br>

### 動作確認用テストユーザーについて
テスト用のユーザが TestUserSeeder.php によって作成されます（DatabaseSeeder.phpに登録済み）<br>
以下のアカウント情報でログインしてください
| 入力欄| 入力内容 |
| --- | --- |
| メールアドレス | `test@example.com` |
| パスワード| `password` |

このテスト用ユーザでは、出品、購入、お気に入り登録した商品が確認できます

### Stripe決済画面接続後の注意点について
Stripeの決済画面接続後は、ブラウザの「戻る」ボタンをクリックしないようにしてください<br>
※ 決済のキャンセルを行いたい場合は、商品名の上にある「←」をクリックしてください


## テストの実行について
Laravel Dusk を用いてテストを作成しています<br>
テストの実行前に、テスト用のデータベースを以下の手順で作成してください
1. `docker-compose exec mysql bash`
2. `mysql -u root -p`
3. パスワード `root` を入力
4. `CREATE DATABASE demo_test;`
5. `SHOW DATABASES;` で「demo_test」データベースが作成されていることを確認

以上が完了したら、phpコンテナから以下のコマンドでテストを実行してください<br>
`php artisan dusk test/Browser/テストファイル名`<br>
※ tests/Browser/ に作成したテストファイルには、対象のテストケースIDを記しています<br>
※ テストによってはスクリーンショットを取得するので、tests/Browser/screenshots/ を確認してください<br>


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
- ユーザー登録 : [http://localhost/register/](http://localhost/register)
- phpMyAdmin : [http://localhost:8080/](http://localhost:8080/)
- MailHog : [http://localhost:8025/](http://localhost:8025/)
