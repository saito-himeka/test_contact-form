@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>Contact</h2>
    </div>
    <form class="form" action="/confirm" method="post">
        @csrf
    <!-----------------name---------------------->
        <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">お名前</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <input type="text" name="last_name" placeholder="例:山田" value="{{ old('last_name') }}" required/>
            <input type="text" name="first_name" placeholder="例:太郎" value="{{ old('first_name') }}" required/>
            <div class="form__error">
            @error('last_name')
                {{ $message }}
            @enderror
            @error('first_name')
                {{ $message }}
            @enderror
            </div>
        </div>
        </div>
    <!-----------------gender-------------------->
        <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">性別</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <label><input type="radio" name="gender" value="1" required> 男性</label>
            <label><input type="radio" name="gender" value="2"> 女性</label>
            <label><input type="radio" name="gender" value="3"> その他</label>
            <!--<input type="radio" name="gender"  value="{{ old('gender') }}" />-->
            <div class="form__error">
            @error('gender')
            {{ $message }}
            @enderror
            </div>
        </div>
        </div>
    <!-----------------email--------------------->
        <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">メールアドレス</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
            <input type="email" name="email" placeholder="test@example.com" value="{{ old('email') }}" />
            </div>
            <div class="form__error">
            @error('email')
            {{ $message }}
            @enderror
            </div>
        </div>
        </div>
    <!------------------tel--------------------->
        <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">電話番号</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
                <input type="text" name="tel1" pattern="\d{2,4}" maxlength="4" placeholder="080">
            <span>-</span>
                <input type="text" name="tel2" pattern="\d{2,4}" maxlength="4" placeholder="1234">
            <span>-</span>
                <input type="text" name="tel3" pattern="\d{3,4}" maxlength="4" placeholder="5678">
            <!--<input type="tel" name="tel" placeholder="09012345678" value="{{ old('tel') }}" />-->
            <div class="form__error">
            @error('tel')
            {{ $message }}
            @enderror
            </div>
        </div>
        </div>
    <!-----------------address-------------------->
        <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">住所</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
            <input type="text" name="address" placeholder="例:東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}" />
            </div>
            <div class="form__error">
            @error('address')
            {{ $message }}
            @enderror
            </div>
        </div>
        </div>
    <!----------------building------------------->
        <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">建物名</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
            <input type="text" name="building" placeholder="千駄ヶ谷マンション101" value="{{ old('building') }}" />
            </div>
            <div class="form__error">
            @error('building')
            {{ $message }}
            @enderror
            </div>
        </div>
        </div>
    <!------------category----------------->
        <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">お問い合わせの種類</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
            <select name="category_id" required>
            <option value="" selected>選択してください</option>
            <option value="1">商品のお届けについて</option>
            <option value="2">商品の交換について</option>
            <option value="3">商品トラブル</option>
            <option value="4">ショップへのお問い合わせ</option>
            <option value="5">その他</option>
            </select>
            </div>
            <div class="form__error">
            @error('category')
            {{ $message }}
            @enderror
            </div>
        </div>
        </div>
    <!-----------------detail-------------------->
        <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">お問い合わせ内容</span>
            <span class="form__label--required">※</span>
        </div>
        </div>
        <div class="form__group-content">
            <div class="form__input--textarea">
            <textarea name="detail" placeholder="資料をいただきたいです">{{ old('detail') }}</textarea>
            </div>
        </div>
        </div>
        <div class="form__button">
        <button class="form__button-submit" type="submit">確認画面</button>
        </div>
    </form>
</div>
@endsection
