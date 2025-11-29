# test_contact-form

## アプリケーション概要
- Laravel 8 を使用した簡易お問い合わせフォームアプリケーションです。
- Dockerで開発環境を構築可能。

---

## 環境構築手順

1. **リポジトリをクローン**
```bash
git clone git@github.com:saito-himeka/test_contact-form.git
cd test_contact-form
```

2. **Dockerコンテナを起動**
```bash
docker-compose up -d --build
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

6. **ストレージ・キャッシュの権限設定**
```bash
chmod -R 777 storage bootstrap/cache
```

7. **データベースをマイグレーション**
```bash
php artisan migrate
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
## ER図

```mermaid
erDiagram
    categories {
        bigint id PK "お問い合わせの種類のID"
        varchar(255) content "お問い合わせ内容の選択肢"
        timestamp created_at
        timestamp updated_at
    }
    
    contacts {
        bigint id PK "お問い合わせID"
        bigint category_id FK "お問い合わせ種類ID"
        varchar(255) first_name "姓"
        varchar(255) last_name "名"
        tinyint gender "性別 (1:男性, 2:女性, 3:その他)"
        varchar(255) email "メールアドレス"
        varchar(255) tel "電話番号"
        varchar(255) address "住所"
        varchar(255) building "建物名など"
        text detail "お問い合わせ詳細"
        timestamp created_at
        timestamp updated_at
    }

    users {
        bigint id PK "ユーザーID"
        varchar(255) name "ユーザー名"
        varchar(255) email "メールアドレス"
        varchar(255) password "パスワード"
        timestamp created_at
        timestamp updated_at
    }

    # リレーションの定義: contactsテーブルはcategoriesテーブルのcategory_idに依存する
    # 一つのカテゴリ（お問い合わせの種類）に、複数のcontacts（お問い合わせ）が紐づく
    categories ||--o{ contacts : has
    
    # ※備考: usersテーブルとcontactsテーブルの間にリレーションがないため、ここでは定義していません。
    # ユーザーがログインして問い合わせる場合は、usersテーブルからcontactsテーブルへのFKが必要になります。
