<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;

class SaleApiController extends Controller
{
    /**
     * 売上一覧表示 (API用)
     */
    public function index()
    {
        $sales = Sale::with('product')->orderBy('created_at', 'desc')->get();
        return response()->json($sales); // JSON形式で売上一覧を返す
    }

    /**
     * 売上登録処理 (API用)
     */
    public function store(Request $request)
    {
        try {
            // バリデーション
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);
        
            $product = Product::findOrFail($request->product_id);
            $amount = $product->price * $request->quantity;
        
            // 在庫を減らす（必要であればチェック）
            if ($product->stock < $request->quantity) {
                return response()->json(['error' => '在庫が足りません。'], 400); // 在庫不足の場合はエラーレスポンス
            }
        
            // 在庫を減らす
            $product->stock -= $request->quantity;
            $product->save();
        
            // 売上登録
            $sale = Sale::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'amount' => $amount,
            ]);
        
            return response()->json($sale, 201); // 登録成功のレスポンス（201 Created）
        
        } catch (\Exception $e) {
            // エラーの詳細をロギングし、ユーザーには一般的なメッセージを返却
            \Log::error('Sale registration failed: ' . $e->getMessage());
            return response()->json(['error' => '内部サーバーエラー'], 500); // 一般的なエラーレスポンス
        }
    }
}
