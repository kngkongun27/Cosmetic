@extends('front.layout.master')

@section('title', 'Check Out')

@section('body')
<!-- Checkout Section Start -->
<div class="checkout-section spad">
    <div class="container">
        <form action="" method="POST" class="checkout-form">
            @csrf
            <div class="row">

                @if( Cart::count() > 0)
                <div class="col-lg-6">
                    <div class="checkout-content">
                        <a href="login.html" class="content-btn">Đến Trang Đăng Nhập</a>
                    </div>
                    <h4>Thông Tin Đơn Hàng</h4>

                    <div class="row">


                        <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id ?? ''   }}">
                        <div class="col-lg-6">
                            <label for="fir">Tên khách hàng <span>*</span></label>
                            <input type="text" id="fir" name="first_name" value="{{ Auth::user()->name ?? '' }}">
                        </div>
                     
                        <div class="col-lg-12">
                            <label for="street">Địa chỉ <span>*</span></label>
                            <input type="text" id="street" name="street_address" class="street-first" value="{{ Auth::user()->street_address ?? ''}}">

                        </div>


                        <div class="col-lg-6">
                            <label for="email">Email<span>*</span></label>
                            <input type="text" id="email" name="email" value="{{ Auth::user()->email ?? ''}}">
                        </div>
                        <div class="col-lg-6">
                            <label for="phone">Số điện thoại <span>*</span></label>
                            <input type="text" id="phone" name="phone" value="{{ Auth::user()->phone ?? ''}}">
                        </div>
                        <div class="col-lg-12">
                            <div class="create-item">
                                <label for="acc-create">
                                    Tạo tài khoản ?
                                    <input type="checkbox" id="acc-create">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="checkout-content">
                        <input type="text" placeholder="Enter your email">
                    </div>
                    <div class="place-order">
                        <h4>Đơn hàng của bạn</h4>
                        <div class="order-total">
                            <ul class="order-table">
                                <li>Sản phẩm <span>Tổng</span></li>

                                @foreach($carts as $cart)

                                <li class="fw-normal">
                                    {{ $cart->name }} x {{$cart->qty}}
                                    <span>{{ format_price($cart->price * $cart->qty) }}</span>
                                </li>
                                <li>
                                    {{$cart->product_id}}
                                </li>
                                @endforeach
                                <li class="fw-normal">SubTotal(Tổng tiền trước thuế) <span>{{$subtotal}}0đ</span></li>
                                <li class="total-price">Tổng tiền <span>{{$total}}0đ</span></li>
                            </ul>
                            <div class="payment-check">
                                <div class="pc-item">
                                    <label for="pc-check">
                                        Trả Sau
                                        <input type="radio" name="payment_type" value="pay_later" id="pc-check" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="pc-item">
                                    <label for="pc-paypal">
                                        Thanh Toán Trực Tuyến
                                        <input type="radio" name="payment_type" value="online_payment" id="pc-paypal">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="order-btn">
                                <button type="submit" class="site-btn place-btn">Đặt Hàng</button>
                            </div>
                        </div>
                    </div>
                </div>

                @else
                <div class="col-lg-12">
                    <h4>Giỏ hàng của bạn đang trống , vui lòng quay lại mua hàng thêm </h4>
                </div>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
