@extends('layouts.app')

@section('content')
<div class="container">
    <h1>売上登録フォーム</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        <div>
            <label>商品：</label>
            <select name="product_id">
                <option value="">-- 商品を選択してください --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>個数：</label>
            <input type="number" name="quantity" value="{{ old('quantity') }}" min="1">
        </div>

        <div>
            <button type="submit">登録</button>
        </div>
    </form>

    <p><a href="{{ route('sales.index') }}">← 売上一覧に戻る</a></p>
</div>
@endsection
