@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<main>
        <div class="login-container">
            <h2 class="login-title">Login</h2>

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">メールアドレス</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="例: test@example.com">
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">パスワード</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="例: coachtech1106">
                {{-- バリデーションエラー表示 --}}
                    @if ($errors->any())
                        <div class="login-error">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>
                <button type="submit" class="login-button">ログイン</button>
            </form>
        </div>
    </main>
@endsection