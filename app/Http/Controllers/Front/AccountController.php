<?php

namespace App\Http\Controllers\Front;

use App\Ultilities\Constant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Order\OrderServiceInterface;
use App\Service\OrderDetail\OrderDetailServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Service\User\UserServiceInterface;


class AccountController extends Controller
{

    private $userService;
    private $orderService;
    private $orderDetailService;

    public function __construct(UserServiceInterface $userService, OrderServiceInterface $orderService, OrderDetailServiceInterface $orderDetailService)
    {
        $this->userService = $userService;
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
    }

    public function login()
    {

        return view('front.account.login', []);
    }


    public function checkLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'level' => Constant::user_level_client,
        ];

        $remember = $request->remember;

        if (Auth::attempt($credentials, $remember)) {
            //return redirect('');
            return redirect()->intended(''); // Mặc định là trang chủ
        } else {
            return back()->with('notification', 'Đăng nhập thất bại');
        }
    }

    public function logout()
    {
        Auth::logout();

        return back();
    }

    public function register()
    {
        return view('front.account.register');
    }

    public function postRegister(Request $request)
    {


        if ($request->password != $request->password_confirmation) {
            return back()
                ->with('notification', 'Có lỗi : Mật khẩu xác nhận không trùng khớp');
        }
        $data = [
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => bcrypt($request->password),
            'phone'          => $request->phone,
            'street_address' => $request->street_address,
            'town_city'      => $request->town_city,
            'description'    => $request->description,
            'skin_type'      => $request->skin_type,   // ✅ lưu loại da
            'level'          => Constant::user_level_client,
        ];

        $this->userService->create($data);

        return redirect('account/login')
            ->with('notification', 'Đăng ký thành công, trở lại trang đăng nhập');
    }

    public function myOrderIndex()
    {
        $orders = $this->orderService->getOrderByUserId(Auth::id());


        return view('front.account.my-order.index', [
            'orders' => $orders,

        ]);
    }

    public function myOrderShow($id)
    {
        $order = $this->orderService->find($id);


        return view('front.account.my-order.show', [
            'order' => $order,

        ]);
    }
}
