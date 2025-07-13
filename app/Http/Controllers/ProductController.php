<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest; // もしProductRequestを使用していない場合は削除してください

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // デフォルトのソート順をid降順に設定
        $sortColumn = $request->input('sort');
        $sortOrder = $request->input('order');
        if (empty($sortColumn)) {
            $sortColumn = 'id';
            $sortOrder = 'desc'; // 初期表示をid降順に強制
        }
        $request->merge(['sort' => $sortColumn, 'order' => $sortOrder]); // リクエストにデフォルト値をマージ

        // buildFilteredQuery を使用してクエリを構築
        $query = $this->buildFilteredQuery($request);
        // 通常のindexページではページネーションを適用
        $products = $query->paginate(5); // 例: 1ページあたり5件表示

        $companies = Company::all();

        return view('products.index', compact('products', 'companies'));
    }

    // ⭐︎ この ajaxSearch メソッドを追加します
    public function ajaxSearch(Request $request)
    {
        // buildFilteredQuery を使用してクエリを構築
        $query = $this->buildFilteredQuery($request);
        // Ajax検索ではページネーションなしで全件取得（またはAjax用のページネーションを別途実装）
        $products = $query->get();

        // 部分ビューをレンダリングし、Content-Typeを明示的にtext/htmlとして返す
        return response(view('products.partials.product_table', compact('products'))->render())
               ->header('Content-Type', 'text/html');
    }

    // 検索・フィルタリング・ソートのロジックを共通化するためのプライベートメソッド
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

    public function store(Request $request) // ProductRequestを使用しない場合はRequest $requestに変更
    {
        // ProductRequestを使用していない場合、ここでバリデーションを定義
        $request->validate([
            'product_name' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // image_path に変更
        ]);

        try {
            $product = new Product();
            $product->product_name = $request->product_name;
            $product->company_id = $request->company_id;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;

            if ($request->hasFile('image_path')) { // image_path に変更
                $path = $request->file('image_path')->store('products', 'public'); // products フォルダに保存
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

    public function update(Request $request, $id) // ProductRequestを使用しない場合はRequest $requestに変更
    {
        // ProductRequestを使用していない場合、ここでバリデーションを定義
        $request->validate([
            'product_name' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // image_path に変更
        ]);

        try {
            $product = Product::findOrFail($id);

            $product->product_name = $request->product_name;
            $product->company_id = $request->company_id;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;

            if ($request->hasFile('image_path')) { // image_path に変更
                if ($product->image_path) {
                    Storage::disk('public')->delete($product->image_path);
                }
                $path = $request->file('image_path')->store('products', 'public'); // products フォルダに保存
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

            // AjaxリクエストならJSONレスポンスを返す
            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }

            // 通常のHTMLリクエストの場合
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
