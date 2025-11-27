<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Service\Product\ProductServiceInterface;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{

    private $productService;
    //
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }



    public function index()
    {
        $carts = Cart::content();
        $total = Cart::total();
        $subtotal = Cart::subtotal();


        return view('front.shop.cart', [
            'carts' => $carts,
            'total' => $total,
            'subtotal' => $subtotal,


        ]);
    }


    public function add(Request $request)
    {
        if ($request->ajax()) {
            $product = $this->productService->find($request->productId);

            // Tính tổng số lượng sản phẩm theo size
            $totalQuantity = $product->productDetails->sum('qty');

            // Nếu hết hàng thì trả về lỗi
            if ($totalQuantity == 0) {
                return response()->json(['error' => 'Sản phẩm đã hết hàng!'], 400);
            }

            // Lấy lựa chọn người dùng
            $selectedColor = $request->color ?? null;
            $selectedVolume = $request->volume ?? null;

            // Thêm vào giỏ
            $response['cart'] = Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->discount ?? $product->price,
                'weight' => $product->weight ?? 0,
                'options' => [
                    'images' => $product->productImages,
                    'color' => $selectedColor,
                    'volume' => $selectedVolume,
                ],
            ]);

            $response['count'] = Cart::count();
            $response['total'] = Cart::total();

            return $response;
        }
        return back();
    }


    public function delete(Request $request)
    {
        if ($request->ajax()) {
            $response['cart'] = Cart::remove($request->rowId);

            $response['count'] = Cart::count();
            $response['total'] = Cart::total();
            $response['subtotal'] = Cart::subtotal();

            return $response;
        }

        return back();
    }
    public function destroy()
    {
        Cart::destroy();
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $response['cart'] = Cart::update($request->rowId, $request->qty);

            $response['count'] = Cart::count();
            $response['total'] = Cart::total();
            $response['subtotal'] = Cart::subtotal();

            return $response;
        }
    }
}
