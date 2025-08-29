<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use DataTables;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $tags = Tag::get();
            return Datatables::of($tags)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $edit_route = route('tag.edit', $row->id);
                $btn = '<a href="'.$edit_route.'" class="edit btn btn-primary btn-sm">Edit</a>';
                $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.tag.index_tag');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tag.add_tag');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tag_name' => 'required|unique:tags,tag_name'
        ]);

        $insert_data = $request->all();

        Tag::create($insert_data);
        return redirect()->route('tag.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tag.edit_tag', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'tag_name' => 'required|unique:tags,tag_name,'.$tag->id
        ]);

        $update_data = $request->all();

        $tag->update($update_data);
        return redirect()->route('tag.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response(['status' => true]);
    }
}
