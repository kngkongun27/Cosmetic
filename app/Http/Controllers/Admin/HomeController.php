<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Ultilities\Constant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function getLogin()
    {

        return view('admin.login', []);
    }


    //  hàm check đăng nhập và quyền 
    public function postLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'level' => [Constant::user_level_host && Constant::user_level_admin], // tài khoản cấp độ host hoặc admin
        ];

        $remember = $request->remember;

        if (Auth::attempt($credentials, $remember)) {
            //return redirect('');
            return redirect()->intended('admin'); // Mặc định là trang chủ
        } else {
            return back()->with('notification', 'Đăng nhập thất bại');
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect('admin/login');
    }
}
