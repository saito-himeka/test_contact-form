# test_contact-form

## アプリケーション概要
- Laravel 8 を使用した簡易お問い合わせフォームアプリケーションです。
- Dockerで開発環境を構築可能。
- ER図は現在作成中です（docs/ER_diagram.png に後日追加予定）。

---

## 環境構築手順

1. **リポジトリをクローン**
```bash
git clone git@github.com:saito-himeka/test_contact-form.git
cd test_contact-form
```

2. **Dockerコンテナを起動**
```bash
docker-compose exec php bash
```

3. **PHPコンテナに入る**
```bash
docker-compose exec php bash
```

4. **依存パッケージをインストール**
```bash
composer install
```

5. **環境設定ファイルを作成**
```bash
cp .env.example .env
php artisan key:generate
```

6. **データベースをマイグレーション＆シード**
```bash
php artisan migrate --seed
```

## 使用技術/バージョン
- laravel 8.83.29
- php 8.1.33
- nginx 1.21.1
- mysql 8.0.26


## URL
- 開発環境:http://localhost
- ユーザー登録:http://localhost/register
- phpMyAdmin:http://localhost:8080
    - ユーザー名:laravel_user
    - パスワード:laravel_pass


## ER図
- 現在作成中です。完成後、docs/ER_diagram.png に追加予定。