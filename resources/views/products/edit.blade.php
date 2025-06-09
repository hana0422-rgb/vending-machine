@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報編集画面</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="product-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <label>ID：</label>
            <input type="text" value="{{ $product->id }}" disabled>
        </div>

        <div class="form-row">
            <label>商品名：</label>
            <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
        </div>

        <div class="form-row">
            <label>メーカー名：</label>
            <input type="text" name="maker_name" value="{{ old('maker_name', $product->maker_name) }}">
        </div>

        <div class="form-row">
            <label>価格：</label>
            <input type="number" name="price" min="1" value="{{ old('price', $product->price) }}" required>
        </div>

        <div class="form-row">
            <label>在庫数：</label>
            <input type="number" name="stock" min="0" value="{{ old('stock', $product->stock) }}" required>
        </div>

        <div class="form-row">
            <label>コメント：</label>
            <textarea name="comment">{{ old('comment', $product->comment) }}</textarea>
        </div>

        <div class="form-row">
            <label>会社：</label>
            <select name="company_id" required>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id', $product->company_id) == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <label>商品画像：</label>
            <input type="file" name="image_path" accept="image/*">
            @if ($product->image_path)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像" width="120">
                </div>
            @endif
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">更新</button>
            <a href="{{ route('products.index') }}" class="btn-back">戻る</a>
        </div>
    </form>
</div>
@endsection
