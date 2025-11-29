@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<main>
        <h2 class="page-heading">Register</h2>

        <div class="register-container">
            <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">お名前</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="例: 山田 太郎">
                    @error('name')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">メールアドレス</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="例: test@example.com">
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">パスワード</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="例: coachtech1106">
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="register-button">登録</button>
            </form>
        </div>
</main>
@endsection