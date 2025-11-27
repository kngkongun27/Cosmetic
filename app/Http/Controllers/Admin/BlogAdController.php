<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Service\Blog\BlogServiceInterface;

class BlogAdController extends Controller
{
    private $blogService;
    public function __construct(BlogServiceInterface $blogService)
    {
        $this->blogService = $blogService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $blogs = $this->blogService
            ->searchAndPaginate('title', $request->get('search'));

        return view('admin.blog.index', [
            'blogs' => $blogs,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $blogs = $this->blogService->all();

        return view('admin.blog.create', [
            // 'blogs' => $blogs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        // Validate cơ bản
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Xử lý upload ảnh
        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Đặt tên file: timestamp + slug + extension
            $imageName = time() . '-' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();

            // Lưu vào storage/app/public/blog
            $image->storeAs('public/blog', $imageName);
        }

        // Chuẩn bị dữ liệu
        $data = [
            'user_id' => 3, // hoặc Auth::id()
            'title' => $request->title,
            'content' => $request->content,
            'slug' => Str::slug($request->title),
            'image' => $imageName,
            'category' => $request->category,
        ];

        // Lưu vào DB
        $this->blogService->create($data);

        return redirect('admin/blog')->with('success', 'Thêm bài viết thành công!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $blog = $this->blogService->find($id);
        //     //return $product;
        // return view('admin.blog.index', [
        //     'blog' => $blog,
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog  = $this->blogService->find($id);
        return view('admin.blog.edit', [
            'blog' => $blog,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $data = $request->only(['title', 'subtitle', 'content', 'category']);

        // Upload ảnh mới nếu có
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ (nếu có)
            if ($blog->image && Storage::exists('public/blog/' . $blog->image)) {
                Storage::delete('public/blog/' . $blog->image);
            }

            $imageName = time() . '-' . Str::slug(pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/blog', $imageName);

            $data['image'] = $imageName;
        }

        $blog->update($data);

        return redirect('admin/blog')->with('success', 'Cập nhật bài viết thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Lấy bài viết
        $blog = $this->blogService->find($id);

        // Xóa file ảnh nếu tồn tại
        if (!empty($blog->image)) {
            $path = storage_path('app/public/blog/' . $blog->image);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->blogService->delete($id);

        return redirect('admin/blog')->with('success', 'Xóa bài viết thành công!');
    }
}
