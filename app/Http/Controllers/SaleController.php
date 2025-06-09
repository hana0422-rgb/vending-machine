<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;

class SaleController extends Controller
{
    /**
     * 売上一覧表示
     */
    public function index()
    {
        $sales = Sale::with('product')->orderBy('created_at', 'desc')->get();
        return view('sales.index', compact('sales'));
    }

    /**
     * 売上登録フォーム表示
     */
    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    /**
     * 売上登録処理
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $product = Product::findOrFail($request->product_id);
        $amount = $product->price * $request->quantity;
    
        // 在庫を減らす（必要であればチェック）
        if ($product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => '在庫が足りません。'])->withInput();
        }
    
        $product->stock -= $request->quantity;
        $product->save();
    
        // 売上登録
        Sale::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'amount' => $amount,
        ]);
    
        return redirect()->route('sales.index')->with('success', '売上を登録しました。');
    }
}