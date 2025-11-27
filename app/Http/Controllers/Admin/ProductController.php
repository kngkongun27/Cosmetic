<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Brand\BrandServiceInterface;
use App\Service\Product\ProductServiceInterface;
use App\Service\ProductCategory\ProductCategoryService;
use App\Service\ProductCategory\ProductCategoryServiceInterface;

class ProductController extends Controller
{
    private $productService;
    private $brandService;
    private $productCategoryService;

    public function __construct(
        ProductServiceInterface $productService,
        BrandServiceInterface $brandService,
        ProductCategoryServiceInterface $productCategoryService
    ) {
        $this->productService = $productService;
        $this->brandService = $brandService;
        $this->productCategoryService = $productCategoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $products = $this->productService
            ->searchAndPaginate('name', $request->get('search'));


        return view('admin.product.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = $this->brandService->all();

        $productCategories = $this->productCategoryService->all();
        return view('admin.product.create', [
            'brands' => $brands,
            'productCategories' => $productCategories,
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
        $data = $request->all();

        // Xóa dấu chấm trong các giá trị tiền
        $data['price'] = str_replace('.', '', $request->price);
        $data['originalPr'] = str_replace('.', '', $request->originalPr);
        $data['discount'] = str_replace('.', '', $request->discount);

        // Chuyển số về dạng DECIMAL chuẩn (nếu cần)
        $data['price'] = (float) $data['price'];
        $data['originalPr'] = (float) $data['originalPr'];
        $data['discount'] = (float) $data['discount'];

        // Default quantity
        $data['qty'] = 0;

        $product = $this->productService->create($data);

        return redirect('admin/product/' . $product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productService->find($id);
        //return $product;
        return view('admin.product.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product  = $this->productService->find($id);

        $brands = $this->brandService->all();
        $productCategories = $this->productCategoryService->all();

        return view('admin.product.edit', [
            'product' => $product,
            'brands' => $brands,
            'productCategories' => $productCategories,
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
        $data = $request->all();

        $this->productService->update($data, $id);

        return redirect('admin/product/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->productDetails()->delete();

        $product->productImages()->delete();

        $product->productComments()->delete();

        $product->delete();

        return redirect('admin/product')->with('success', 'Xóa sản phẩm thành công!');
    }
}
