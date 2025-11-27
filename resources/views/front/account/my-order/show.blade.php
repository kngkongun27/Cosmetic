@extends('front.layout.master')

@section('title', 'My Order')

@section('body')

<!--  My Order Section Begin -->

<section class="checkout-section spad">
    <div class="container">
        <form action="#" class="checkout-form">
            <div class="row">
                <div class="col-lg-6">
                    <div class="checkout-content">
                        <a href="#" class="content-btn">
                            Mã Đơn Hàng:
                            <b>#{{ $order->id }}</b>

                        </a>
                    </div>
                    <h4>Chi Tiết Đơn Hàng</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="fir">Họ</label>
                            <input disabled type="text" id="fir" value="{{ $order->first_name }}">
                        </div>
                        <div class="col-lg-6">
                            <label for="fir">Tên</label>
                            <input disabled type="text" id="last" value="{{ $order->last_name }}">
                        </div>
                        <div class="col-lg-12">
                            <label for="cun-name">Nơi làm việc</label>
                            <input disabled type="text" id="cun-name" value="{{ $order->company_name }}">
                        </div>
                        <div class="col-lg-12">
                            <label for="cun">Nơi ở</label>
                            <input disabled type="text" id="cun" value="{{ $order->country }}">
                        </div>
                        <div class="col-lg-12">
                            <label for="street">Địa chỉ</label>
                            <input disabled type="text" id="street" class="street-first" value="{{ $order->street-address }}">
                        </div>
                        <div class="col-lg-12">
                            <label for="zip">Mã Zip</label>
                            <input disabled type="text" id="zip" value="{{ $order->postcode_zip }}">
                        </div>
                        <div class="col-lg-12">
                            <label for="town">Thành phố</label>
                            <input disabled type="text" id="town" value="{{ $order->town_city }}">
                        </div>
                        <div class="col-lg-6">
                            <label for="email">Email</label>
                            <input disabled type="text" id="email" value="{{ $order->email }}">
                        </div>
                        <div class="col-lg-6">
                            <label for="phone">Số điện thoại</label>
                            <input disabled type="text" id="phone" value="{{ $order->phone }}">
                        </div>

                    </div>
                </div>
                <div class="col-lg-">
                    <div class="checkout-content">
                        <a href="#" class="content-btn">
                            Status:
                            <b>{{ \App\Ultilities\Constant::$order_status[$order->status] }}</b>
                        </a>
                    </div>
                    <div class="place-order">
                        <h4>Your Order</h4>
                        <div class="order-total">
                            <ul class="order-table">
                                <li>Sản Phẩm <span>Tổng</span></li>

                                @foreach( $order->orderDetails as $orderDetail)
                                <li class="fw-normal">{{$orderDetail->product->name}} x {{ $orderDetail->qty}} <span>{{$orderDetail->total}}</span></li>


                                <li class="total-price">Tổng <span>${{ array_sum(array_column($order->orderDetails->toArray(), 'total')) }}</span></li>

                                @endforeach
                            </ul>
                            <div class="payment-check">
                                <div class="pc-item">
                                    <label for="pc-check">
                                        Trả Sau
                                        <input type="radio" disabled name="payment_type" value="pay_later" id="pc-check" {{ $order->payment_type == 'pay-later' ? 'checked' : '' }}>
                                        <span class="checkmark"> </span>
                                    </label>
                                </div>
                                <div class="pc-item">
                                    <label for="pc-check">
                                       Thanh Toán Trực Tuyến
                                        <input type="radio" disabled name="payment_type" value="online_payment" id="pc-paypal" {{ $order->payment_type == 'online_payment' ? 'checked' : '' }}>
                                        <span class="checkmark"> </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection