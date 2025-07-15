<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest; 

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $sortColumn = $request->input('sort');
        $sortOrder = $request->input('order');
        if (empty($sortColumn)) {
            $sortColumn = 'id';
            $sortOrder = 'desc'; 
        }
        $request->merge(['sort' => $sortColumn, 'order' => $sortOrder]); 

       
        $query = $this->buildFilteredQuery($request);
        
        $products = $query->paginate(5); 

        $companies = Company::all();

        return view('products.index', compact('products', 'companies'));
    }

  
    public function ajaxSearch(Request $request)
    {
       
        $query = $this->buildFilteredQuery($request);
       
        $products = $query->get();

        
        return response(view('products.partials.product_table', compact('products'))->render())
               ->header('Content-Type', 'text/html');
    }

    private function buildFilteredQuery(Request $request)
    {
        $query = Product::with('company');

        // 商品名キーワード検索
        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->input('keyword') . '%');
        }

        // メーカー（会社）絞り込み
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->input('company_id'));
        }

        // 価格範囲検索
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // 在庫数範囲検索
        if ($request->filled('min_stock')) {
            $query->where('stock', '>=', $request->input('min_stock'));
        }
        if ($request->filled('max_stock')) {
            $query->where('stock', '<=', $request->input('max_stock'));
        }

        // ソート
        if ($request->filled('sort') && $request->filled('order')) {
            $query->orderBy($request->input('sort'), $request->input('order'));
        }

        return $query;
    }

    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    public function store(Request $request) 
    {

        $request->validate([
            'product_name' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        try {
            $product = new Product();
            $product->product_name = $request->product_name;
            $product->company_id = $request->company_id;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;

            if ($request->hasFile('image_path')) { 
                $path = $request->file('image_path')->store('products', 'public'); 
                $product->image_path = $path;
            }

            $product->save();

            return redirect()->route('products.index')->with('success', '商品を登録しました。');
        } catch (\Exception $e) {
            \Log::error('商品登録中にエラーが発生しました: ' . $e->getMessage());
            return back()->withErrors(['error' => '登録に失敗しました。'])->withInput();
        }
    }

    public function show($id)
    {
        $product = Product::with('company')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    public function update(Request $request, $id) 
    {

        $request->validate([
            'product_name' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        try {
            $product = Product::findOrFail($id);

            $product->product_name = $request->product_name;
            $product->company_id = $request->company_id;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;

            if ($request->hasFile('image_path')) { 
                if ($product->image_path) {
                    Storage::disk('public')->delete($product->image_path);
                }
                $path = $request->file('image_path')->store('products', 'public'); 
                $product->image_path = $path;
            }

            $product->save();

            return redirect()->route('products.index')->with('success', '商品を更新しました。');
        } catch (\Exception $e) {
            \Log::error('商品更新中にエラーが発生しました: ' . $e->getMessage());
            return back()->withErrors(['error' => '更新に失敗しました。'])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $product->delete();

            
            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }

  
            return redirect()->route('products.index')->with('success', '商品を削除しました。');
        } catch (\Exception $e) {
            \Log::error('商品削除中にエラーが発生しました: ' . $e->getMessage());
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => '削除に失敗しました。'], 500);
            }

            return back()->withErrors(['error' => '削除に失敗しました。']);
        }
    }
}
