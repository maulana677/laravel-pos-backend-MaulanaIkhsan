<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            'image'     => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'name'     => 'required|min:3',
            'description'   => 'nullable|min:3',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required'
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        // $data = $request->all();

        // $product = new \App\Models\Product;
        // $product->name = $request->name;
        // $product->description = $request->description;
        // $product->price = (int) $request->price;
        // $product->stock = (int) $request->stock;
        // $product->category = $request->category;
        // $product->image = $filename;
        // $product->save();

        //create post
        Product::create([
            'image' => $filename,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category
        ]);

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
        $product = Product::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //delete old image
            Storage::delete('public/products/' . $product->image);

            //upload new image
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products/', $filename);

            $data = $request->except('image');
            $data['image'] = $filename;
            $product->update($data);
        } else {
            $product->update($request->all());
        }

        toast('Product updated successfully', 'success')->width('400');
        return redirect()->route('product.index');
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            Storage::delete('public/products/' . $product->image);
            $product->delete();
            return response(['status' => 'success', 'message' => 'Product successfully deleted']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => 'There is something wrong!']);
        }
        // $product = \App\Models\Product::findOrFail($id);
        // $product->delete();
        // return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
