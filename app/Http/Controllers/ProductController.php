<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = DB::table('products')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        return view('pages.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        \App\Models\Product::create($data);

        toast('Product created successfully', 'success')->width('400');
        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('pages.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $products = \App\Models\Product::findOrFail($id);
        $products->update($data);

        toast('Product updated successfully', 'success')->width('400');
        return redirect()->route('product.index');
    }

    public function destroy($id)
    {
        try {
            $user = Product::findOrFail($id);
            $user->delete();
            return response(['status' => 'success', 'message' => 'User successfully deleted']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => 'There is something wrong!']);
        }
    }
}
