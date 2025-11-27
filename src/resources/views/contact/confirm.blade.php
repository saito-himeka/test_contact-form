@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<main class="container">
        <h2 class="page-title">Confirm</h2>

        <form action="/store" method="post">
            @csrf

            <!-- Hidden（DBへ送る値） -->
            <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
            <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
            <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
            <input type="hidden" name="email" value="{{ $contact['email'] }}">
            <input type="hidden" name="tel" value="{{ $contact['tel'] }}">
            <input type="hidden" name="address" value="{{ $contact['address'] }}">
            <input type="hidden" name="building" value="{{ $contact['building'] }}">
            <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
            <input type="hidden" name="detail" value="{{ $contact['detail'] }}">

            <div class="confirm-table">
                <table class="confirm-table__inner">

                <!-- 名前 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お名前</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['last_name'] }} {{ $contact['first_name'] }}" readonly />
                    </td>
                </tr>

                <!-- 性別 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">性別</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['gender_name'] }}" readonly>
                    </td>
                </tr>

                <!-- メール -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">メールアドレス</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['email'] }}" readonly />
                    </td>
                </tr>

                <!-- 電話番号 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">電話番号</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['tel'] }}" readonly />
                    </td>
                </tr>

                <!-- 住所 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">住所</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['address'] }}" readonly />
                    </td>
                </tr>

                <!-- 建物名 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">建物名</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['building'] }}" readonly />
                    </td>
                </tr>

                <!-- カテゴリー -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせの種類</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['category_name'] }}" readonly>
                    </td>
                </tr>

                <!-- 詳細 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせ内容</th>
                    <td class="confirm-table__text">
                        <input type="textarea" value="{{ $contact['detail'] }}" readonly />
                    </td>
                </tr>

            </table>
            </div>
            
            <div class="button-area">
                <button type="submit" class="btn-submit">送信</button>
                <button type="button" class="btn-modify" onclick="history.back()">修正</button>
            </div>
        </form>
    </main>
@endsection