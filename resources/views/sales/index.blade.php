@extends('layouts.app')

@section('content')
<div class="container">
    <h1>売上一覧</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品名</th>
                <th>数量</th>
                <th>合計金額</th>
                <th>登録日時</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->product->product_name ?? '不明' }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->amount }}</td>
                    <td>{{ $sale->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('products.index') }}" class="btn btn-secondary">商品一覧に戻る</a>
</div>
@endsection
