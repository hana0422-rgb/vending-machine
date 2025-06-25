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
        $query = Product::with('company');

        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->input('keyword') . '%');
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->input('company_id'));
        }

        $products = $query->paginate(5);
        $companies = Company::all();

        return view('products.index', compact('products', 'companies'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    public function store(ProductRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('img_path')) {
                $path = $request->file('img_path')->store('images', 'public');
                $data['img_path'] = $path;
            }

            Product::create($data);

            return redirect()->route('products.index')->with('success', '商品を登録しました。');
        } catch (\Exception $e) {
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

    public function update(ProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $data = $request->validated();

            if ($request->hasFile('img_path')) {
                if ($product->img_path) {
                    Storage::disk('public')->delete($product->img_path);
                }
                $path = $request->file('img_path')->store('images', 'public');
                $data['img_path'] = $path;
            }

            $product->update($data);

            return redirect()->route('products.index')->with('success', '商品を更新しました。');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => '更新に失敗しました。'])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->img_path) {
                Storage::disk('public')->delete($product->img_path);
            }

            $product->delete();

            return redirect()->route('products.index')->with('success', '商品を削除しました。');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => '削除に失敗しました。']);
        }
    }
}