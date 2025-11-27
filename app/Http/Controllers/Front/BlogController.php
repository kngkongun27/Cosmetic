<?php

namespace App\Http\Controllers\Front;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();

        // return $blogs;
        return view('front.blog.index', [
            'blogs' => $blogs,
        ]);
    }

    public function getBlog()
    {
        $blogs = Blog::select('id', 'title', 'subtitle', 'slug', 'image', 'created_at')
            ->latest()
            ->get();

        return response()->json($blogs);
    }

    public function detail($slug)
    {
        // Trả về view có Vue để hiển thị chi tiết bài viết
        return view('front.blog.detail');
    }

    public function getBlogDetail($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $related = Blog::where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get(['id', 'title', 'slug', 'image', 'created_at']);

        return response()->json([
            'blog' => $blog,
            'related' => $related
        ]);
    }
}
