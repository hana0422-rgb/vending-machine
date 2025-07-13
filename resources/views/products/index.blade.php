@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧</h1>

    <form id="search-form" method="GET" action="{{ route('products.search') }}" class="search-form-candidate1">
        <div class="search-inputs">
            {{-- 最初の行: 検索キーワードとメーカー名 --}}
            <div class="search-row">
                <input type="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}">
                <select name="company_id">
                    <option value="">メーカー名</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 2番目の行: 価格範囲と在庫数範囲 --}}
            <div class="search-row">
                <div class="input-group">
                    <input type="number" name="min_price" placeholder="最小価格" value="{{ request('min_price') }}">
                    <span class="input-separator">〜</span>
                    <input type="number" name="max_price" placeholder="最大価格" value="{{ request('max_price') }}">
                </div>

                <div class="input-group">
                    <input type="number" name="min_stock" placeholder="最小在庫数" value="{{ request('min_stock') }}">
                    <span class="input-separator">〜</span>
                    <input type="number" name="max_stock" placeholder="最大在庫数" value="{{ request('max_stock') }}">
                </div>
            </div>

            <input type="hidden" name="sort" id="sort" value="{{ request('sort') }}">
            <input type="hidden" name="order" id="order" value="{{ request('order', 'asc') }}">
        </div>

        <div class="search-buttons">
            <button type="submit" class="btn btn-primary">検索</button>
            <a href="{{ route('products.create') }}" class="btn btn-success">新規登録</a>
        </div>
    </form>

    <!-- 商品一覧テーブル -->
    <div id="product-table">
        @include('products.partials.product_table', ['products' => $products])
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/product-search.js') }}"></script>
<script>
    $(document).on('click', '.btn-delete', function () {
        if (!confirm('本当に削除しますか？')) return;

        const button = $(this);
        const productId = button.data('id');
        const row = button.closest('tr');

        $.ajax({
            url: `/products/${productId}`,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}',
            },
            success: function () {
                row.remove();
            },
            error: function () {
                alert('削除に失敗しました');
            }
        });
    });
</script>
@endsection
