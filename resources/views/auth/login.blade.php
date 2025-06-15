@extends('layouts.app')

@section('content')
<div class="form-container">
    <h1 class="form-title">Login</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="メールアドレス" required>
        <input type="password" name="password" placeholder="パスワード" required>
        <button type="submit" class="btn-login-main">ログイン</button>


    </form>

    <a href="{{ route('register.form') }}" class="link-to-register">新規登録はこちら</a>
</div>
@endsection
