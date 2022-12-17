<?php

namespace App\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::search()->orderBy('id', 'desc')->paginate(4);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        try {
            $request->validated();
            Category::create($request->all());
            return redirect()->route('category.index')->with('message', "Insert Data Successfully");
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
        $category = Category::find($id);
        return view('admin.category.detail', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = Category::find($id);
        return view('admin.category.update', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $request->validated();
            Category::find($id)->update($request->all());
            return redirect()->route('category.index')->with('message', "Update Data Successfully");
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
        $categorry = Category::find($id);
        try {
            if ($categorry->products->count() > 0) {
                return redirect()->route('category.index')->with('message', 'This Category Already Have Product, Cannot Delete !');
            } else {
                $categorry->delete();
                return redirect()->route('category.recycle_bin')->with('message', 'Moved This Category To RecycleBin !');
            }
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function recycle_bin()
    {
        $categories = Category::onlyTrashed()->get();
        return view('admin.category.recycle_bin', compact('categories'));
    }

    public function restore($id)
    {
        try {
            Category::withTrashed()->find($id)->restore();
            return redirect()->route('category.index')->with('message', 'Restore Successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function force_delete($id)
    {
        try {
            Category::withTrashed()->find($id)->forceDelete();
            return redirect()->route('category.index')->with('message', 'Force Delete Successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
