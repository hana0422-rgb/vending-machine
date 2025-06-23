@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品新規登録画面</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="product-form">
        @csrf

        <div class="form-row">
            <label>商品名：</label>
            <input type="text" name="product_name" value="{{ old('product_name') }}" required>
        </div>

        <div class="form-row">
            <label>メーカー名：</label>
            <input type="text" name="maker_name" value="{{ old('maker_name') }}">
        </div>

        <div class="form-row">
            <label>価格：</label>
            <input type="number" name="price" min="1" value="{{ old('price') }}" required>
        </div>

        <div class="form-row">
            <label>在庫数：</label>
            <input type="number" name="stock" min="0" value="{{ old('stock') }}" required>
        </div>

        <div class="form-row">
            <label>コメント：</label>
            <textarea name="comment">{{ old('comment') }}</textarea>
        </div>

     <div class="form-row">
    <label for="company_id">会社：</label>  {{-- ←ここだけ表示名を修正 --}}
    <select name="company_id" id="company_id" class="form-control">
        <option value="">選択してください</option>
        @foreach ($companies as $company)
            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
        @endforeach
    </select>
</div>

        <div class="form-row">
            <label>商品画像：</label>
            <input type="file" name="image_path" accept="image/*">
        </div>
        <div class="form-buttons">
    <button type="submit" class="btn-submit">新規登録</button>
    <a href="{{ route('products.index') }}" class="btn-back">戻る</a>
</div>
    </form>
</div>
@endsection
