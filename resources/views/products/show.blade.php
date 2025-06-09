@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報詳細画面</h1>
    <table class="table product-detail-table">
    <tr>
        <th>ID</th>
        <td>{{ $product->id }}</td>
    </tr>
    <tr>
        <th>商品名</th>
        <td>{{ $product->product_name }}</td>
    </tr>
    <tr>
        <th>メーカー</th>
        <td>{{ $product->company->company_name ?? '' }}</td>
    </tr>
    <tr>
        <th>価格</th>
        <td>{{ $product->price }} 円</td>
    </tr>
    <tr>
        <th>在庫数</th>
        <td>{{ $product->stock }}</td>
    </tr>
    <tr>
        <th>コメント</th>
        <td>{{ $product->comment }}</td>
    </tr>
    <tr>
        <th>商品画像</th>
        <td>
            @if($product->image_path)
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像" width="200">
            @else
                画像なし
            @endif
        </td>
    </tr>
</table>

<!-- 左下に配置するボタン -->
<div class="button-group-left">
    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">編集</a>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
</div>

</div>
@endsection
