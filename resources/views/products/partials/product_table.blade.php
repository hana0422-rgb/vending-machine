<table class="table">
    @php
        $currentSort = request('sort');
        $currentDirection = request('order') === 'asc' ? 'desc' : 'asc';
    @endphp

    <thead>
        <tr>
            <th><a href="#" class="sort-link" data-column="id" data-order="{{ $currentSort === 'id' ? $currentDirection : 'asc' }}">ID</a></th>
            <th>商品画像</th>
            <th><a href="#" class="sort-link" data-column="product_name" data-order="{{ $currentSort === 'product_name' ? $currentDirection : 'asc' }}">商品名</a></th>
            <th><a href="#" class="sort-link" data-column="price" data-order="{{ $currentSort === 'price' ? $currentDirection : 'asc' }}">価格</a></th>
            <th><a href="#" class="sort-link" data-column="stock" data-order="{{ $currentSort === 'stock' ? $currentDirection : 'asc' }}">在庫数</a></th>
            <th>メーカー名</th>
            <th>操作</th>
        </tr>
    </thead>

    <tbody id="product-table-body">
        @foreach ($products as $product)
        <tr data-id="{{ $product->id }}">
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
            <td class="d-flex product-actions-cell" style="gap: 8px; justify-content: center;">
    <a href="{{ route('products.show', $product->id) }}" class="btn-action btn-detail">詳細</a>
    <button class="btn-delete" data-id="{{ $product->id }}">削除</button>
</td>

        </tr>
        @endforeach
    </tbody>
</table>
