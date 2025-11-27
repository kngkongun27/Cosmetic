<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Brand\BrandServiceInterface;

class BrandController extends Controller
{

    private $brandService;

    public function __construct(BrandServiceInterface $brandService)
    {
        $this->brandService = $brandService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $brands = $this->brandService->searchAndPaginate('name', $request->get('search'));

        return view('admin.brand.index', [
            'brands' => $brands,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
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

        $this->brandService->create($data);

        return redirect('admin/brand');
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
        $brand = $this->brandService->find($id);

        return view('admin.brand.edit', [
            'brand' => $brand,
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

        $this->brandService->update($data, $id);

        return redirect('admin/brand');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        // return $brand;
        // Duyệt toàn bộ sản phẩm thuộc brand
        foreach ($brand->products as $product) {

            // Nếu sản phẩm đang nằm trong đơn hàng thì chặn xóa
            if ($product->orderDetails()->exists()) {
                // return 1;
                return back()->with('error', 'Không thể xóa. Sản phẩm "' . $product->name . '" đang nằm trong đơn hàng.');
            }

            // Xóa ảnh sản phẩm nếu có
            foreach ($product->productImages as $image) {
                $path = storage_path('app/public/' . $image->path);
                if (file_exists($path)) {
                    unlink($path);
                }
                $image->delete();
            }

            // Xóa sản phẩm
            $product->delete();
        }

        // Xóa thương hiệu
        $brand->delete();

        return redirect('admin/brand')->with('success', 'Đã xóa thương hiệu và toàn bộ sản phẩm không liên quan đơn hàng.');
    }
}
