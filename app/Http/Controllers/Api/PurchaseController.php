<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; // ⭐︎ Validator ファサードをuseに追加
use Illuminate\Support\Facades\Log; // ⭐︎ Log ファサードをuseに追加 (エラーログ用)

class PurchaseController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ], [
  
            'product_id.required' => '商品IDは必須です。',
            'product_id.exists' => '指定された商品IDは存在しません。',
            'quantity.required' => '購入数量は必須です。',
            'quantity.integer' => '購入数量は整数でなければなりません。',
            'quantity.min' => '購入数量は1以上でなければなりません。',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); 
        }

  
        $validated = $validator->validated();

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($validated['product_id']);

       
            if ($product->stock < $validated['quantity']) {
   
                return response()->json(['error' => '指定された数量の在庫がありません。現在の在庫は' . $product->stock . '個です。'], 400);
            }


            $product->stock -= $validated['quantity'];
            $product->save();


            Sale::create([
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'amount' => $product->price * $validated['quantity'],
            ]);

            DB::commit();

            return response()->json(['message' => '購入が完了しました。'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
         
            Log::error('購入処理中にエラーが発生しました: ' . $e->getMessage());
            return response()->json(['error' => '購入処理中に予期せぬエラーが発生しました。'], 500);
        }
    }
}
