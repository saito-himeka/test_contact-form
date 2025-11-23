#アプリケーション名
-test_contact-form

##環境構築
-git clone git@github.com:saito-himeka/test_contact-form.git

-Docker-compose up -d --build
-docker-compose exec php bash
-composer create-project "laravel/laravel=8.*" . --prefer-dist
-php artisan migrate
-php artisan db:seed

##使用技術(実行環境)
-laravel 8.83.29
-php 8.1.33
-nginx 1.21.1
-mysql 8.0.26 

##URL
-開発環境:http://localhost
－ユーザー登録:http://localhost/register
-phpMyAdmin:http://localhost:8080


##ER図