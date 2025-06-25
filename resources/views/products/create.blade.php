@extends('layouts.app')

@section('content')
    <h1>商品新規登録画面</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-row">
            <label for="product_name">商品名：</label>
            <input type="text" name="product_name" value="{{ old('product_name') }}">
        </div>

        <div class="form-row">
            <label for="company_id">会社：</label>
            <select name="company_id" id="company_id" class="form-control">
                <option value="">選択してください</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <label for="price">価格：</label>
            <input type="number" name="price" value="{{ old('price') }}">
        </div>

        <div class="form-row">
            <label for="stock">在庫数：</label>
            <input type="number" name="stock" value="{{ old('stock') }}">
        </div>

        <div class="form-row">
            <label for="comment">コメント：</label>
            <textarea name="comment">{{ old('comment') }}</textarea>
        </div>

        <div class="form-row">
            <label for="image">商品画像：</label>
            <input type="file" name="image">
        </div>

        <div class="form-row">
            <button type="submit">新規登録</button>
            <a href="{{ route('products.index') }}">戻る</a>
        </div>
    </form>
@endsection
