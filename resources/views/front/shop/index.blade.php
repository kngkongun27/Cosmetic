@extends('front.layout.master')

@section('title', 'Shop')

@section('body')
<!-- Beadcrumb Section Begin -->
<div class="beacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="/"><i class="fa fa-home"></i></a>
                    <span>Shop</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Beadcrumb Section Begin -->

<!-- Product Shop Section Begin -->
<section class="product-shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                @include('front.shop.components.products-sidebar-filter')
            </div>
            <div class="col-lg-9 order-1 order-lg-2" style="background:#fafafa;">
                <div class="product-show-option">
                    <div class="row">
                        <div class="col-lg-7 col-md-7">
                            <form action="">
                                <div class="select-option">
                                    <select name="sort_by" onchange="this.form.submit();" class="sorting">
                                        <option {{ request('sort_by') == 'latest' ? 'selected' : '' }} value="latest">Sắp xếp: Mới Nhất</option>
                                        <option {{ request('sort_by') == 'oldest' ? 'selected' : '' }} value="oldest">Sắp xếp: Cũ Nhất</option>
                                        <option {{ request('sort_by') == 'nameascending' ? 'selected' : '' }} value="nameascending">Sắp Xếp: Tên A-Z</option>
                                        <option {{ request('sort_by') == 'namedescending' ? 'selected' : '' }} value="namedescending">Sorting: Tên Z-A</option>
                                        <option {{ request('sort_by') == 'priceascending' ? 'selected' : '' }} value="priceascending">Sorting: Giá tăng dần </option>
                                        <option {{ request('sort_by') == 'pricedescending' ? 'selected' : '' }} value="pricedescending">Sorting: Giá giảm dần</option>

                                    </select>
                                    <select name="show" onchange="this.form.submit();" class="p-show">
                                        <option {{ request('show') == '3' ? 'selected' : '' }}value="3">Show : 3</option>
                                        <option {{ request('show') == '9' ? 'selected' : '' }}value="9">Show : 9</option>
                                        <option {{ request('show') == '15' ? 'selected' : '' }}value="15">Hiển Thị: 15</option>
                                    </select>
                                </div>
                            </form>

                        </div>
                        <!-- <div class="col-lg-5 col-md-5 text-right">
                            <p>Show 01-09 of 27 Product</p>
                        </div> -->
                    </div>
                </div>
                <div class="product-list">
                    <div class="row">
                        @foreach($products as $product)

                        @include('front.components.product-item-details')
                        @endforeach
                    </div>
                </div>
                <!-- <div class="loading-more">
                <i class="icon_loading">
                 
                </i>
                <a href="#">Bạn chờ lâu nhé</a>
               </div> -->
                {{ $products->links() }}

            </div>
        </div>
    </div>
</section>


@endsection