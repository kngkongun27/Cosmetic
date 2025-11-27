@extends('front.layout.master')

@section('title', 'Check Out')

@section('body')

<!-- My order Section Begin  -->

<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cart-table">
                    <table>
                        <thead>
                            <th>Ảnh sản phẩm</th>
                            <th>Id</th>
                            <th>Tên sản phẩm</th>
                            <th>Tổng</th>
                            <th>Chi Tiết</th>
                        </thead>
                        <tbody>

                            @foreach($orders as $order)
                            <tr>
                                <td class="cart-pic first-row">
                                    <img style="height:100px;" src="{{ isset($order->orderDetails[0]->product->productImages[0]) 
                ? asset($order->orderDetails[0]->product->productImages[0]->path) 
                : asset('storage/products/default-product.png') }}" alt="{{ $order->orderDetails[0]->product->name }}"> </td>
                                <td class="first-row">#{{ $order->id }}</td>
                                <td class="cart-title first-row">
                                    <h5>{{ $order->orderDetails[0]->product->name }}</h5>
                                </td>
                                <td class="total-price first-row">${{ array_sum(array_column($order->orderDetails->toArray(), 'total' )) }}</td>
                                <td class="first-row">
                                    <a href="./account/my-order/{{ $order->id }}" class="btn">Details</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
