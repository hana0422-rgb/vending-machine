@extends('layouts.app')

@section('content')
<div class="form-container">
    <h1 class="form-title">ユーザー新規登録画面</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
        <input type="password" name="password" placeholder="パスワード">

        <button type="submit">新規登録</button>

        <a href="{{ route('login.form') }}">← ログイン画面へ戻る</a>
    </form>
</div>
@endsection
