<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // $products = DB::table('products')
        //     ->when($request->input('name'), function ($query, $name) {
        //         return $query->where('name', 'like', '%' . $name . '%');
        //     })
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(10);

        $products = Product::orderBy('id', 'DESC')->get();
        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        return view('pages.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products',
            'description' => 'nullable|min:3',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|in:food,drink,snack',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $data = $request->all();

        $product = new \App\Models\Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category = $request->category;
        $product->image = $filename;
        $product->save();

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
        // $product = \App\Models\Product::findOrFail($id);
        // $product->delete();
        // return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
