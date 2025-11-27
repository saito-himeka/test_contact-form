@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<main class="container">
        <h2 class="page-title">Admin</h2>

        <form class="search-form">
            <input type="text" class="input-text" placeholder="名前やメールアドレスを入力してください">
            
            <select class="select-box">
                <option value="">性別</option>
                <option value="male">男性</option>
                <option value="female">女性</option>
                <option value="other">その他</option>
            </select>

            <select class="select-box">
                <option value="">お問い合わせの種類</option>
                <option value="1">商品の交換について</option>
                <option value="2">返品について</option>
                <option value="3">その他</option>
            </select>

            <select class="select-box">
                <option value="">年/月/日</option>
            </select>

            <button type="button" class="btn-search">検索</button>
            <button type="button" class="btn-reset">リセット</button>
        </form>

        <div class="action-bar">
            <button class="btn-export">エクスポート</button>
            <div class="pagination">
                <a href="#" class="page-link">&lt;</a>
                <a href="#" class="page-link active">1</a>
                <a href="#" class="page-link">2</a>
                <a href="#" class="page-link">3</a>
                <a href="#" class="page-link">4</a>
                <a href="#" class="page-link">5</a>
                <a href="#" class="page-link">&gt;</a>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>お名前</th>
                        <th>性別</th>
                        <th>メールアドレス</th>
                        <th>お問い合わせの種類</th>
                        <th></th> </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>山田 太郎</td>
                        <td>男性</td>
                        <td>test@example.com</td>
                        <td>商品の交換について</td>
                        <td><a href="#" class="btn-detail">詳細</a></td>
                    </tr>
                    <tr>
                        <td>山田 太郎</td>
                        <td>男性</td>
                        <td>test@example.com</td>
                        <td>商品の交換について</td>
                        <td><a href="#" class="btn-detail">詳細</a></td>
                    </tr>
                    <tr>
                        <td>山田 太郎</td>
                        <td>男性</td>
                        <td>test@example.com</td>
                        <td>商品の交換について</td>
                        <td><a href="#" class="btn-detail">詳細</a></td>
                    </tr>
                    <tr>
                        <td>山田 太郎</td>
                        <td>男性</td>
                        <td>test@example.com</td>
                        <td>商品の交換について</td>
                        <td><a href="#" class="btn-detail">詳細</a></td>
                    </tr>
                    <tr>
                        <td>山田 太郎</td>
                        <td>男性</td>
                        <td>test@example.com</td>
                        <td>商品の交換について</td>
                        <td><a href="#" class="btn-detail">詳細</a></td>
                    </tr>
                    <tr>
                        <td>山田 太郎</td>
                        <td>男性</td>
                        <td>test@example.com</td>
                        <td>商品の交換について</td>
                        <td><a href="#" class="btn-detail">詳細</a></td>
                    </tr>
                    <tr>
                        <td>山田 太郎</td>
                        <td>男性</td>
                        <td>test@example.com</td>
                        <td>商品の交換について</td>
                        <td><a href="#" class="btn-detail">詳細</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
@endsection