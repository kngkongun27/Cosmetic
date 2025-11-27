<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Service\Order\OrderServiceInterface;
use App\Service\OrderDetail\OrderDetailServiceInterface;

class CheckoutController extends Controller
{
    private $orderService;
    private $orderDetailService;

    public function __construct(
        OrderServiceInterface $orderService,
        OrderDetailServiceInterface $orderDetailService
    ) {
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
    }

    public function index()
    {

        $carts = Cart::content();
        $lang = Cookie::get('lang');
        $total = Cart::total();
        $subtotal = Cart::subtotal();
        return view('front.checkout.index', [
            'carts' => $carts,
            'total' => $total,
            'subtotal' => $subtotal,
            'lang' => $lang,
        ]);
    }

    public function addOrder(Request $request)
    {
        // Thêm status = 1 vào dữ liệu khi tạo đơn hàng
        $orderData = $request->all();
        $orderData['status'] = 1;

        $order = $this->orderService->create($orderData);

        $carts = Cart::content();
        $lang = Cookie::get('lang');

        foreach ($carts as $cart) {
            $productId = $cart->id;
            $orderedQuantity = $cart->qty;

            $product = Product::find($productId);

            $data = [
                'order_id' => $order->id,
                'product_id' => $productId,
                'qty' => $orderedQuantity,
                'amount' => $cart->price,
                'total' => $orderedQuantity * $cart->price,
                // Nếu là makeup thì lưu màu
                'color' => strtolower($product->tag) === 'makeup' ? ($cart->options->color ?? null) : null,
                // Nếu là skin care thì lưu dung tích
                'volume' => strtolower($product->tag) === 'skincare' ? ($cart->options->volume ?? null) : null,
            ];

            $this->orderDetailService->create($data);

            // Cập nhật số lượng sản phẩm sau mỗi item
            $this->updateProductQuantity($productId, $orderedQuantity);
        }

        if ($request->payment_type == 'pay_later') {
            $total = Cart::total();
            $subtotal = Cart::subtotal();
            $this->sendEmail($order, $total, $subtotal);
        }

        Cart::destroy();

        return redirect('checkout/result')
            ->with('notification', 'Bạn đã hoàn thành đặt hàng, vui lòng kiểm tra lại email');
    }



    public function result()
    {

        $notification = session('notification');
        $lang = Cookie::get('lang');
        return view('front.checkout.result', [
            'notification'  => $notification,
            'lang' => $lang,
        ]);
    }

    public function sendEmail($order, $total, $subtotal)
    {
        $email_to = $order->email;

        Mail::send(
            'front.checkout.email',
            [
                'order' => $order,
                'total' => $total,
                'subtotal' => $subtotal,

            ],
            function ($message) use ($email_to) {
                $message->from('halloguy12345@gmail.com', 'Manh Cosmetic');
                $message->to($email_to, $email_to);
                $message->subject('Thông tin đơn hàng');
            }
        );
    }


    private function updateProductQuantity($productId, $orderedQuantity)
    {
        $product = Product::with('productDetails')->findOrFail($productId);

        $remainingStock = $product->productDetails->sum('qty');

        if ($remainingStock < $orderedQuantity) {
            return redirect('checkout/result')
                ->with('notification', 'Sản phẩm trong kho không đủ, vui lòng quay lại và kiểm tra');
        }
        $toDeduct = $orderedQuantity;
        foreach ($product->productDetails as $detail) {
            if ($toDeduct <= 0) {
                break;
            }

            $available = $detail->qty;
            $deduct = min($available, $toDeduct);

            $detail->qty = $available - $deduct;
            $detail->save();

            $toDeduct -= $deduct;
        }
    }
}
