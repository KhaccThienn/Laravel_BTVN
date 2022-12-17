<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::search()->filter()->orderBy('id', 'desc')->paginate(3);
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        try {
            $request->validated();
            $file_name = time() . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads'), $file_name);
            Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'image' => $file_name,
                'category_id' => $request->category_id,
                'status' => $request->status,
                'description' => $request->description
            ]);
            return redirect()->route('product.index')->with('message', "Insert Data Successfully !");
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prod = Product::find($id);
        $categories = Category::get();
        return view('admin.product.update', compact('prod', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $prod = Product::find($id);
            $request->validated();
            $file_name = $prod->image;
            if ($request->has('image')) {
                $file_name = time() . $request->image->getClientOriginalName();
                unlink('uploads/' . $prod->image);
                $request->image->move(public_path('uploads'), $file_name);
            }
            $prod->update([
                'name' => $request->name,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'image' => $file_name,
                'category_id' => $request->category_id,
                'status' => $request->status,
                'description' => $request->description
            ]);
            return redirect()->route('product.index')->with('message', "Update Data Successfully !");
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->route('product.recycle_bin')->with('message', 'Moved This Product To Recyclebin Successfully!');
    }

    public function recycle_bin()
    {
        $products = Product::onlyTrashed()->get();
        return view('admin.product.recycle_bin', compact('products'));
    }

    public function restore($id)
    {
        try {
            Product::withTrashed()->find($id)->restore();
            return redirect()->route('product.index')->with('message', 'Restore Successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function force_delete($id)
    {
        try {
            $product =  Product::withTrashed()->find($id);
            unlink('uploads/' . $product->image);
            $product->forceDelete();
            return redirect()->route('product.index')->with('message', 'Force Delete Successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
