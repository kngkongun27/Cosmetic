
@extends('front.layout.master')

@section('title', 'Login')

@section('body')
<!-- Main Login Start  -->
<div class="beacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="/"><i class="fa fa-home"></i>Home</a>
                    <a href="login.html">Đăng Nhập</a>

                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Registers Login Main -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="login-form">
                        <h2>Đăng Nhập</h2>

                        @if(session('notification'))
                                <div class="alert alert-warning" role="alert">
                                        {{ session('notification') }}
                                </div>
                        @endif
                        <form action="" method="post">
                            @csrf
                            <div class="group-input">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email">
                            </div>
                            <div class="group-input">
                                <label for="password">Mật khẩu *</label>
                                <input type="password" id="password" name="password">
                            </div>
                            <div class="group-input gi-check">
                                <div class="gi-more">
                                    <label for="save-pass">
                                       Lưu mật khẩu
                                        <input type="checkbox" id="save-pass" name="remember">
                                        <span class="checkmark"></span>
                                    </label>
                                    <a href="#" class="forget-pass">Bạn quên mật khẩu ?</a> <br>
                                    <a href="../admin/login" class="forget-pass">Vào trang quản trị -></a>
                                </div>
                            </div>
                            <button type="submit" class="site-btn login-btn">Đăng nhập</button>

                            
                        </form>
                        <div class="switch-login">
                            <a href="./account/register" class="or-login">Hoặc Tạo Tài Khoản</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


   