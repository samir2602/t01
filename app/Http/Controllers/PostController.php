<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {               
        if($request->ajax()){
            $posts = Post::with('category');            
            return Datatables::of($posts)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $edit_route = route('post.edit', $row->id);
                $btn = '<a href="'.$edit_route.'" class="edit btn btn-primary btn-sm">Edit</a>';
                $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->editColumn('post_category', function ($row) {
                return $row->category->category_name;
            })
            ->editColumn('post_image', function ($row) {
                return '<img src="'.url('post_image').'/'.$row->post_image.'" style="width:10%; height:auto">';
            })
            ->rawColumns(['action', 'post_category', 'post_image'])
            ->make(true);
        }
        return view('admin.post.index_post');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tag = Tag::get();
        $category = Category::get();
        return view('admin.post.add_post', compact('tag', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_title' => 'required|max:50|unique:posts,post_title',
            'post_content' => 'required|min:50|max:500',
            'post_auther' => 'required',
            'post_image' => 'required|image|mimes:jpeg,jpg,png,webp',
            'category_id' => 'required',
        ]);

        $insert_post = $request->all();        
        
        if($request->tag_ids){
            $insert_post['tag_ids'] = implode(", ", $request->tag_ids);
        }

        if($request->post_image){
            $insert_post['post_image'] = $insert_post['post_title'].'.'.$request->post_image->getClientOriginalExtension();
            $request->post_image->move(public_path('post_image'), $insert_post['post_image']);
        }
        Post::create($insert_post);
        return redirect()->route('post.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $tag = Tag::get();
        $category = Category::get();
        $tags_id = explode(',', $post->tag_ids);
        return view('admin.post.edit_post', compact('post', 'tag', 'category', 'tags_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'post_title' => 'required|max:50|unique:posts,post_title,'.$post->id,
            'post_content' => 'required|min:50|max:500',
            'post_auther' => 'required',            
            'category_id' => 'required',
        ]);

        $update_post = $request->all();
        
        if($request->tag_ids){
            $update_post['tag_ids'] = implode(", ", $request->tag_ids);
        }

        if($request->post_image){
            $old_image = public_path('post_image').'/'.$post->post_image;
            unlink($old_image);
            $update_post['post_image'] = $update_post['post_title'].'.'.$request->post_image->getClientOriginalExtension();
            $request->post_image->move(public_path('post_image'), $update_post['post_image']);
        }
        
        $post->update($update_post);
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response(['status' => true]);
    }
}
