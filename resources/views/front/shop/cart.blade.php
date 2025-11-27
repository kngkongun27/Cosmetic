@extends('front.layout.master')

@section('title', 'Shop')

@section('body')

<!-- Start Main Shopping Cart -->
<div class="shopping-cart spad">
    <div class="container">
        <div class="row">
            @if( Cart::count() > 0 )
            <div class="col-lg-12">
                <div class="cart-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Ảnh sản phẩm</th>
                                <th class="p-name">Tên Sản Phẩm</th>
                                <th>Đơn Giá</th>
                                <th>Số Lượng</th>
                                <th>Thành Giá</th>
                                <th><i onclick="confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng ?') === true ? destroyCart() : ''" style="cursor:pointer" class="ti-close"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carts as $cart)
                            <tr data-rowid="{{ $cart->rowId }}">

                                <td class="cart-pic first-row">
                                    <img style="height:170px;" src="{{ isset($cart->options->images[0]->path) 
                ? asset( $cart->options->images[0]->path) 
                : asset('storage/products/default-product.png') }}" alt="{{ $cart->name }}">
                                </td>
                                <td class="cart-title first-row">
                                    <h5>{{ $cart->name }}</h5>
                                </td>
                                <td class="p-price first-row">{{ number_format($cart->price, 2)}}0đ</td>
                                <td class="qua-col first-row">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="{{ $cart->qty }}" data-rowid="{{ $cart->rowId}}">
                                        </div>
                                    </div>
                                </td>
                                <td class="toltal-price first-row">{{ number_format($cart->price * $cart->qty, 2)}}0đ</td>
                                <td class="close-td first-row">
                                    <i onclick="removeCart('{{ $cart->rowId }}')" class="icon_close"></i>

                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="cart-buttons">
                            <a href="#" class="primary-btn continue-shop">Tiếp tục mua sắm</a>
                            <a href="#" class="primary-btn up-cart">Cập nhật Giỏ hàng</a>
                        </div>
                     
                    </div>
                    <div class="col-lg-4 offset-lg-4">
                        <div class="proceed-checkout">
                            <ul>
                                <li class="subtotal">Tổng tiền trước thuế <span>{{ $total }}0đ</span></li>
                                <li class="cart-total">Tổng tiền <span>{{ $subtotal }}0đ</span></li>
                            </ul>
                            <a href="./checkout" class="proceed-btn">Kiểm Tra & Thanh Toán</a>
                        </div>
                    </div>
                </div>
            </div>

            @else
            <div class="col-lg-12">
                <h4>Giỏ hàng của bạn đang trống</h4>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
