<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
    // 商品一覧取得
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    // 商品詳細取得
    public function show(Product $product)
    {
        return response()->json($product, 200);
    }

    // 商品登録
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'company_id' => 'required|integer|exists:companies,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $product = Product::create($validator->validated());

        return response()->json($product, 201);
    }

    // 商品更新
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'company_id' => 'required|integer|exists:companies,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $product->update($validator->validated());

        return response()->json($product, 200);
    }

    // 商品削除
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => '削除完了'], 200);
    }
}
