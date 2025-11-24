@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm__content">
    <div class="confirm__heading">
        <h2>Confirm</h2>
    </div>
    
    <form class="form" action="/" method="post">
        @csrf
        <div class="confirm-table">
        <table class="confirm-table__inner">
        <!------------name------------>
            <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
            <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
            <tr class="confirm-table__row">
            <th class="confirm-table__header">お名前</th>
            <td class="confirm-table__text">
                <input type="text" value="{{ $contact['last_name'] }}{{ $contact['first_name'] }}" readonly />
            </td>
            </tr>
        <!------------gender------------>
            <tr class="confirm-table__row">
            <th class="confirm-table__header">性別</th>
            <td class="confirm-table__text">
                <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
                <input type="text" value="{{ $contact['gender_name'] }}" readonly>
            </td>
            </tr>

        <!------------email------------>
            <tr class="confirm-table__row">
            <th class="confirm-table__header">メールアドレス</th>
            <td class="confirm-table__text">
                <input type="email" name="email" value="{{ $contact['email'] }}" readonly />
            </td>
            </tr>
        <!------------tel------------>
            <tr class="confirm-table__row">
            <th class="confirm-table__header">電話番号</th>
            <td class="confirm-table__text">
                <input type="tel" name="tel" value="{{ $contact['tel'] }}" readonly />
            </td>
            </tr>
        <!------------address------------>
            <tr class="confirm-table__row">
            <th class="confirm-table__header">住所</th>
            <td class="confirm-table__text">
                <input type="text" name="address" value="{{ $contact['address'] }}" readonly />
            </td>
            </tr>
        <!------------building------------>
            <tr class="confirm-table__row">
            <th class="confirm-table__header">建物名</th>
            <td class="confirm-table__text">
                <input type="text" name="building" value="{{ $contact['building'] }}" readonly />
            </td>
            </tr>
        <!------------category------------>
            <tr class="confirm-table__row">
            <th class="confirm-table__header">お問い合わせの種類</th>
            <td class="confirm-table__text">
                <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
                <input type="text" value="{{ $contact['category_name'] }}" readonly>
            </td>
            </tr>
        <!------------detail------------>
            <tr class="confirm-table__row">
            <th class="confirm-table__header">お問い合わせ内容</th>
            <td class="confirm-table__text">
                <input type="text" name="detail" value="{{ $contact['detail'] }}" readonly />
            </td>
            </tr>
        </table>
        </div>
        <div class="form__button">
        <button class="form__button-submit" type="submit">送信</button>
        </div>
    </form>
</div>
@endsection
