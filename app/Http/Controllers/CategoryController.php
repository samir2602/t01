<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $category = Category::get();
            return Datatables::of($category)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $edit_route = route('category.edit', $row->id);
                $btn = '<a href="'.$edit_route.'" class="edit btn btn-primary btn-sm">Edit</a>';
                $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.category.index_category');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.add_category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name'
        ]);
        $insert_data = $request->all();
        Category::create($insert_data);
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit_category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name,'.$category->id
        ]);

        $update_data = $request->all();
        $category->update($update_data);
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response(['status' => true]);
    }
}
