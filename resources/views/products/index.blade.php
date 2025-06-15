@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧</h1>

    <!-- 検索フォーム -->
    <form method="GET" action="{{ route('products.index') }}" class="search-form">
        <input type="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}">
        <select name="company_id">
            <option value="">メーカー名</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                    {{ $company->company_name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn-search">検索</button>
        <a href="{{ route('products.create') }}" class="btn-register">新規登録</a>
    </form>

    <!-- 商品一覧テーブル -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像" width="60">
                    @else
                        画像なし
                    @endif
                </td>
                <td>{{ $product->product_name }}</td>
                <td>¥{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->company->company_name ?? '' }}</td>
<td class="d-flex" style="gap: 8px; justify-content: center;">
    <!-- 詳細ボタン -->
    <a href="{{ route('products.show', $product->id) }}" class="btn-action btn-detail">詳細</a>

    <!-- 削除ボタン -->
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-action delete-btn-red">削除</button>
    </form>
</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ページネーション -->
    <div class="d-flex justify-content-center mt-3">
        @if ($products->lastPage() > 1)
            <div class="pagination">
                @if ($products->onFirstPage())
                    <span class="px-2">&lt;</span>
                @else
                    <a href="{{ $products->appends(request()->query())->previousPageUrl() }}" class="px-2">&lt;</a>
                @endif

                @for ($i = 1; $i <= $products->lastPage(); $i++)
                    @if ($i == $products->currentPage())
                        <span class="px-2 font-weight-bold">{{ $i }}</span>
                    @else
                        <a href="{{ $products->appends(request()->query())->url($i) }}" class="px-2">{{ $i }}</a>
                    @endif
                @endfor

                @if ($products->hasMorePages())
                    <a href="{{ $products->appends(request()->query())->nextPageUrl() }}" class="px-2">&gt;</a>
                @else
                    <span class="px-2">&gt;</span>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection