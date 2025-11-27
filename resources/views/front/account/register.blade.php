@extends('front.layout.master')

@section('title', 'Register')

@section('body')
<!-- Main Register Start  -->
<div class="beacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="/"><i class="fa fa-home"></i>Home</a>
                    <a href="register.html">Đăng Ký</a>
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
                <div class="register-form">
                    <h2>Đăng ký tài khoản</h2>

                    @if(session('notification'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('notification')}}
                    </div>
                    @endif
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="group-input">
                            <label for="name">Tên *</label>
                            <input type="text" id="name" name="name" required>
                        </div>

                        <div class="group-input">
                            <label for="email">Địa chỉ Email *</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="group-input">
                            <label for="password">Mật khẩu *</label>
                            <input type="password" id="password" name="password" required>
                        </div>

                        <div class="group-input">
                            <label for="pass">Xác nhận mật khẩu *</label>
                            <input type="password" id="pass" name="password_confirmation" required>
                        </div>

                        <div class="group-input">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" id="phone" name="phone">
                        </div>

                  

                        <div class="group-input">
                            <label for="street_address">Địa chỉ</label>
                            <input type="text" id="street_address" name="street_address">
                        </div>

                      

                        <div class="group-input">
                            <label for="town_city">Thành phố / Quận</label>
                            <input type="text" id="town_city" name="town_city">
                        </div>

                      
                        <div class="group-input">
                            <label for="description">Mô tả cá nhân</label>
                            <textarea id="description" name="description"></textarea>
                        </div>

                        <!-- ✅ Thêm loại da -->
                        <div class="group-input">
                            <label for="skin_type">Loại da *</label>
                            <select id="skin_type" name="skin_type" required>
                                <option value="">Chọn loại da</option>
                                <option value="da_dau">Da dầu</option>
                                <option value="da_kho">Da khô</option>
                                <option value="da_hon_hop">Da hỗn hợp</option>
                                <option value="da_nhay_cam">Da nhạy cảm</option>
                            </select>
                        </div>

                        <button type="submit" class="site-btn register-btn">Đăng Ký</button>
                    </form>

                    <div class="switch-login">
                        <a href="./account/login.html" class="or-login">Hoặc Đăng Nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
