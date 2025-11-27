<?php

namespace App\Http\Controllers\Admin;


use App\Ultilities\Common;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Service\Product\ProductServiceInterface;

class ProductImageController extends Controller
{
    private $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($product_id)
    {
        $product =  $this->productService->find($product_id);
        $productImages = $product->productImages ?? null;

        return view('admin.product.image.index', [
            'productImages' => $productImages,
            'product' => $product,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // khi tạo người dùng mới thì tạo luôn file upload để lưu ảnh người dùng
    public function store(Request $request, $product_id)
{
    $request->validate([
        'images.*' => 'required|image|max:2048', // kiểm tra từng ảnh
    ]);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $path = Common::uploadFile($file, 'products');

            ProductImage::create([
                'product_id' => $product_id,
                'path' => $path,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Thêm ảnh thành công!');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function destroy($product_id, $product_image_id)
{
    $productImage = ProductImage::find($product_image_id);

    if ($productImage) {
        $filePath = $productImage->path;
        if ($filePath) {
            $storagePath = str_replace('storage/', 'public/', $filePath);
            if (Storage::exists($storagePath)) {
                Storage::delete($storagePath);
            }
        }
        $productImage->delete();
    }

    return redirect()->back()->with('success', 'Xóa ảnh thành công!');
}
}
