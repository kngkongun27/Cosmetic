@extends('admin.layout.master')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

@section('title', 'Category')
@section('body')

<style>
    .status-order {
        padding: 10px;
        border-radius: 8px;
        width: 200px;
        /* Căn chỉnh kích thước theo nhu cầu */
        text-align: center;
    }

    .status-order i {
        font-size: 18px;
        /* Kích thước icon */
    }

    .status-order span {
        font-size: 11px;
        /* Kích thước chữ */
        font-weight: 500;
    }

    .status-order.border-danger {
        background-color: #f8d7da;
        /* Màu nền cho trạng thái hủy */
        color: #842029;
    }

    .status-order.border-dark {
        background-color: #e2e3e5;
        /* Màu nền cho trạng thái chờ */
        color: #41464b;
    }

    .status-order.border-primary {
        background-color: #cfe2ff;
        /* Màu nền cho trạng thái xác nhận */
        color: #084298;
    }

    .status-order.border-warning {
        background-color: #fff3cd;
        /* Màu nền cho trạng thái đang giao */
        color: #664d03;
    }

    .status-order.border-success {
        background-color: #d1e7dd;
        /* Màu nền cho trạng thái giao thành công */
        color: #0f5132;
    }

</style>
<!-- Main -->
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                </div>
                <div>
                    Đơn hàng
                    <div class="page-title-subheading">

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">

                <div class="card-header">

                    <form style="margin:5px;">
                        <div class="input-group">
                            <input type="search" name="search" id="search" value="{{ request('search') }}" placeholder="Gõ từ khóa" class="form-control">
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>&nbsp;
                                    Tìm kiếm
                                </button>
                            </span>
                        </div>
                    </form>

                    <div class="btn-actions-pane-right">
                        <div role="group" class="btn-group-sm btn-group">
                            <button class="btn btn-focus">.</button>
                            <button class="active btn btn-focus">/</button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th>Khách hàng / Sản phẩm</th>
                                <th class="text-center">Địa chỉ</th>
                                <th class="text-center">Tổng</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td class="text-center text-muted">#{{ $order->id }}</td>
                                <td>
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="widget-content-left">
                                                    @if($order->orderDetails->isNotEmpty())
                                                    <img style="height: 60px;" data-toggle="tooltip" title="Image" data-placement="bottom" src="{{ asset($order->orderDetails[0]->product->productImages[0]->path ?? 'default-product.png') }}" alt="">
                                                    @else
                                                    <img style="height: 60px;" data-toggle="tooltip" title="Image" data-placement="bottom" src="{{ asset('default-product.png') }}" alt="">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="widget-content-left flex2">
                                                <div class="widget-heading">{{ $order->first_name . ' ' . $order->lastname }}</div>
                                                <div class="widget-subheading opacity-7">
                                                    @if($order->orderDetails->isNotEmpty())
                                                    {{ $order->orderDetails[0]->product->name }}

                                                    @if($order->orderDetails->count() > 1)
                                                    (and {{ $order->orderDetails->count() - 1 }} other products)
                                                    @endif
                                                    @else
                                                    <span class="text-muted">Chưa có sản phẩm</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    {{ $order->street_address . ' - ' . $order->town_city }}
                                </td>
                                <td class="text-center">
                                    @php
                                    $total = $order->orderDetails->sum('total');
                                    @endphp
                                    {{ format_price($total) }}
                                </td>
                                <td class="text-center">
                                    <div class="badge ">
                                        @switch($order->status)
                                        @case(0)
                                        <div class="status-order d-flex flex-column align-items-center gap-2 border border-danger">
                                            <i class="fa-solid fa-ban text-danger"></i>
                                            <span class="text-start">Hủy đơn hàng</span>
                                        </div>
                                        @break

                                        @case(1)
                                        <div class="status-order d-flex flex-column align-items-center gap-2 border border-dark">
                                            <i class="fa-solid fa-receipt text-dark"></i>
                                            <span class="text-start">Chờ xác nhận</span>
                                        </div>
                                        @break

                                        @case(2)
                                        <div class="status-order d-flex flex-column align-items-center gap-2 border border-primary">
                                            <i class="fa-solid fa-circle-dollar-to-slot text-primary"></i>
                                            <span class="text-start">Xác nhận thành công</span>
                                        </div>
                                        @break

                                        @case(3)
                                        <div class="status-order d-flex flex-column align-items-center gap-2 border border-warning">
                                            <i class="fa-solid fa-truck text-warning"></i>
                                            <span class="text-start">Đang giao</span>
                                        </div>
                                        @break

                                        @case(4)
                                        <div class="status-order d-flex flex-column align-items-center gap-2 border border-success">
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                            <span class="text-start">Giao hàng thành công</span>
                                        </div>
                                        @break
                                        @endswitch
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="./admin/order/{{ $order->id }}" class="btn btn-hover-shine btn-outline-primary border-0 btn-sm">
                                        Chi tiết
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="d-block card-footer">
                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Main -->
@endsection
