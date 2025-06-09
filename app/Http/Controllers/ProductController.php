<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * 商品一覧表示
     */
    public function index(Request $request)
    {
        $query = Product::with('company');

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('product_name', 'like', "%{$keyword}%");
        }

        // メーカー絞り込み
        if ($request->filled('company_id')) {
            $company_id = $request->input('company_id');
            $query->where('company_id', $company_id);
        }

        $products = $query->paginate(10);
        $companies = Company::all();

        return view('products.index', compact('products', 'companies'));
    }

    /**
     * 商品詳細表示
     */
    public function show($id)
    {
        $product = Product::with('company')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * 商品登録フォーム表示
     */
    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    /**
     * 商品登録処理
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'maker_name'   => 'nullable|string',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'image_path' => 'nullable|image'
        ]);

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->maker_name = $request->maker_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
        $product->company_id = $request->company_id;

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('images', 'public');
            $product->image_path = $path;
        }

        $product->save();

        return redirect()->route('products.index');
    }

    /**
     * 商品編集フォーム表示
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品更新処理
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string',
            'maker_name'   => 'nullable|string',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'image_path' => 'nullable|image'
        ]);

        $product = Product::findOrFail($id);
        $product->product_name = $request->product_name;
        $product->maker_name = $request->maker_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
        $product->company_id = $request->company_id;

        if ($request->hasFile('image_path')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $path = $request->file('image_path')->store('images', 'public');
            $product->image_path = $path;
        }

        $product->save();

        return redirect()->route('products.index');
    }

    /**
     * 商品削除処理
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('products.index');
    }
}
