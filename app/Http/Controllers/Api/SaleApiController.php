<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;

class SaleApiController extends Controller
{
    
    public function index()
    {
        $sales = Sale::with('product')->orderBy('created_at', 'desc')->get();
        return response()->json($sales); 
    }

 
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
        
         
            if ($product->stock < $request->quantity) {
                return response()->json(['error' => '在庫が足りません。'], 400); 
            }
        
        
            $product->stock -= $request->quantity;
            $product->save();
        
        
            $sale = Sale::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'amount' => $amount,
            ]);
        
            return response()->json($sale, 201); 
        
        } catch (\Exception $e) {
          
            \Log::error('Sale registration failed: ' . $e->getMessage());
            return response()->json(['error' => '内部サーバーエラー'], 500);
        }
    }
}
