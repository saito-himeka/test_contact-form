@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>Contact</h2>
    </div>
    <form class="form" action="/confirm" method="POST">
        @csrf
    <!-----------------name---------------------->
        <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">お名前</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <input type="text" name="last_name" placeholder="例:山田" value="{{ old('last_name') }}">
            @error('last_name')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <input type="text" name="first_name" placeholder="例:太郎" value="{{ old('first_name') }}">
            @error('first_name')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <div class="form__error">
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
            <label><input type="radio" name="gender" value="1" @checked(old('gender') == 1)> 男性</label>
            <label><input type="radio" name="gender" value="2" @checked(old('gender') == 2)> 女性</label>
            <label><input type="radio" name="gender" value="3" @checked(old('gender') == 3)> その他</label>
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
                <input type="text" name="tel1" value="{{ old('tel1') }}"  pattern="\d{2,4}" maxlength="4" placeholder="080">
            <span>-</span>
                <input type="text" name="tel2" value="{{ old('tel2') }}" pattern="\d{2,4}" maxlength="4" placeholder="1234">
            <span>-</span>
                <input type="text" name="tel3" value="{{ old('tel3') }}" pattern="\d{3,4}" maxlength="4" placeholder="5678">
            @error('tel1')
                <p class="error-message" style="color:red;">{{ $message }}</p>
            @else
                @error('tel2')
                    <p class="error-message" style="color:red;">{{ $message }}</p>
                @enderror
                @error('tel3')
                    <p class="error-message" style="color:red;">{{ $message }}</p>
                @enderror
            @enderror
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
            <select name="category_id">
                <option value="">選択してください</option>
                @foreach ($categories as $category) 
                <option 
                value="{{ $category->id }}" 
                {{ old('category_id') == $category->id ? 'selected' : '' }}> 
                    {{ $category->content }} 
                </option> 
                @endforeach 
            </select> 
            @error('category_id')
                <p class="error-message">{{ $message }}</p> 
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
        
        <div class="form__group-content">
            <div class="form__input--textarea">
            <textarea name="detail" placeholder="資料をいただきたいです">{{ old('detail') }}</textarea>
            </div>
            <div class="form__error">
            @error('detail')
            {{ $message }}
            @enderror
            </div>
        </div>
      </div>
        <div class="form__button">
        <button class="form__button-submit" type="submit">確認画面</button>
        </div>
    </form>
</div>
@endsection
