@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')


<main class="container">
        
    <h2 class="page-title">Contact</h2>

<form action="/confirm" method="post" novalidate>
    @csrf
    <!-----------------name---------------------->
            <div class="form-group">
                <div class="form-label-area">
                    お名前<span class="required-mark">※</span>
                </div>
                <div class="form-input-area">
                    <div class="name-group">
                        
                        <input type="text" class="input-text-half" name="last_name" placeholder="例: 山田" value="{{ old('last_name') }}">
                        
                        <input type="text" class="input-text-half" name="first_name" placeholder="例: 太郎" value="{{ old('first_name') }}">
                    </div>
                    @error('last_name')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                    @error('first_name')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
    <!-----------------gender-------------------->        
            <div class="form-group">
                <div class="form-label-area">
                    性別<span class="required-mark">※</span>
                </div>
                <div class="form-input-area">
                    <div class="radio-group">
                        <label class="radio-item">
                            <input type="radio" name="gender" value="1" {{ old('gender') == '1' ? 'checked' : '' }}>男性
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }}>女性
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }}>その他
                        </label>
                    </div>
                    @error('gender')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
    <!-----------------email--------------------->        
            <div class="form-group">
                <div class="form-label-area">
                    メールアドレス<span class="required-mark">※</span>
                </div>
                <div class="form-input-area">
                    <input type="email" class="input-text" name="email" placeholder="例: test@example.com" value="{{ old('email') }}">
                    @error('email')
                    <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
    <!------------------tel--------------------->        
            <div class="form-group">
                <div class="form-label-area">
                    電話番号<span class="required-mark">※</span>
                </div>
                <div class="form-input-area">
                    <div class="tel-group">
                        <input type="tel" class="tel-input" name="tel1" value="{{ old('tel1') }}"  pattern="\d{2,4}" maxlength="4" placeholder="080">
                        <span>-</span>
                        <input type="tel" class="tel-input" name="tel2" value="{{ old('tel2') }}" pattern="\d{2,4}" maxlength="4" placeholder="1234">
                        <span>-</span>
                        <input type="tel" class="tel-input" name="tel3" value="{{ old('tel3') }}" pattern="\d{3,4}" maxlength="4" placeholder="5678">
                    </div>
                    @error('tel1')
                        <p class="form__error" style="color:red;">{{ $message }}</p>
                    @else
                        @error('tel2')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                        @error('tel3')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    @enderror
                </div>
            </div>
    <!-----------------address-------------------->        
            <div class="form-group">
                <div class="form-label-area">
                    住所<span class="required-mark">※</span>
                </div>
                <div class="form-input-area">
                    <input type="text" class="input-text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}">
                    @error('address')
                    <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
    <!----------------building------------------->        
            <div class="form-group">
                <div class="form-label-area">
                    建物名
                </div>
                <div class="form-input-area">
                    <input type="text" class="input-text" name="building" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building') }}">
                </div>
            </div>
    <!------------category----------------->        
            <div class="form-group">
                <div class="form-label-area">
                    お問い合わせの種類<span class="required-mark">※</span>
                </div>
                <div class="form-input-area">
                    <select class="select-box" name="category_id">
                        <option value="" selected disabled>選択してください</option>
                        @foreach ($categories as $category) 
                        <option 
                        value="{{ $category->id }}" 
                        {{ old('category_id') == $category->id ? 'selected' : '' }}> 
                            {{ $category->content }} 
                        </option> 
                        @endforeach 
                    </select>
                    @error('category_id')
                        <p class="form__error">{{ $message }}</p> 
                    @enderror
                </div>
            </div>
    <!-----------------detail-------------------->        
            <div class="form-group">
                <div class="form-label-area">
                    お問い合わせ内容<span class="required-mark">※</span>
                </div>
                <div class="form-input-area">
                    <textarea class="textarea-content" name="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                    @error('detail')
                    <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <button type="submit" class="btn-confirm">確認画面</button>
            
</form>

{{--<h1>Index</h1>
    <form action="/confirm" method="POST">
    @csrf
    <input type="text" name="name" placeholder="名前">
    <button type="submit">確認へ</button>
    </form>--}}

    </main>
@endsection