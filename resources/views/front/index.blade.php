@extends('front.layout.master')

@section('title', 'Home')

@section('body')

<section class="women-banner" style="background:white;">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-11">
                <div class="homepage-slider-section">
                    <div class="product-slider-h owl-carousel">

                        <div class="slider-item">
                            <img src="/front/img/super-sale-t4.jpg" alt="">
                        </div>

                        <div class="slider-item">
                            <img src="/front/img/set-qua-2010.jpg" alt="">
                        </div>

                        <div class="slider-item">
                            <img src="/front/img/hero-1.1.jpg" alt="">
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-1">
                <div class="right-tags" style="height: 463px;">
                    <div class="tag-item">
                        <img src="/front/img/tag-combo-190x243.png" alt="Combo">
                    </div>
                    <div class="tag-item">
                        <img src="/front/img/tag-clearance-sale-190x243.png" alt="Clearance Sale">
                    </div>
                    <div class="tag-item">
                        <img src="/front/img/tag-chinh-hang-190x243.png" alt="Chính Hãng">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="banner-section spad style-hidden">
    <div class="container-fuild">
        @php
        // Icon và tên hiển thị cho từng tag
        $tagIcons = [
        'makeup' => '/front/img/produc/than-kinh-nao.webp',
        'skincare' => '/front/img/produc/timmach.webp',
        'personalcare' => '/front/img/produc/vitamin.webp',
        'vitamin' => '/front/img/produc/dinhduong.webp',
        ];

        $tagNames = [
        'makeup' => 'MakeUp',
        'skincare' => 'SkinCare',
        'personalcare' => 'Personal Care',
        'vitamin' => 'Thực phẩm chức năng',
        ];
        @endphp

        <div class="row">
            @foreach($tagCounts as $tag => $count)
            <div class="col-lg-3 rounded-lg">
                <div class="single-bannerr">
                    <img src="{{ $tagIcons[$tag] ?? '/front/img/produc/default-icon.webp' }}" class="mx-auto mt-3" alt="{{ $tagNames[$tag] ?? ucfirst($tag) }}" style="width:24px;height:24px">
                    <div class="text-center mx-auto">
                        <h4 class="text-base">{{ $tagNames[$tag] ?? ucfirst($tag) }}</h4>
                        <p class="text-sm">{{ $count }} Sản phẩm</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="hasaki-logo-section">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-2 col-4">
                <div class="logo-item">
                    <img src="/front/img/hasaki-cam-nang.png" alt="Hasaki Cẩm Nang">
                </div>
            </div>

            <div class="col-lg-2 col-4">
                <div class="logo-item">
                    <img src="/front/img/hasaki-clinic.png" alt="Hasaki Clinic">
                </div>
            </div>

            <div class="col-lg-2 col-4">
                <div class="logo-item">
                    <img src="/front/img/hasaki-dat-hen.png" alt="Hasaki Đặt Hẹn">
                </div>
            </div>

            <div class="col-lg-2 col-4">
                <div class="logo-item">
                    <img src="/front/img/hsk-icon-clinic-deals-12-12-2024.png" alt="Hasaki Clinic Deals">
                </div>
            </div>

            <div class="col-lg-2 col-4">
                <div class="logo-item">
                    <img src="/front/img/hsk-icon-nowfree-v2.png" alt="Hasaki Now Free">
                </div>
            </div>

            <div class="col-lg-2 col-4">
                <div class="logo-item">
                    <img src="/front/img/hsk-icon-perfume-v2.png" alt="Hasaki Perfume">
                </div>
            </div>
        </div>
    </div>
</div>


<section class="women-banner ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="filter-control">
                    <ul>
                        <li class="active item" data-tag="*" data-category="adult">Tất cả</li>
                        <li class="item" data-tag=".makeup" data-category="adult">MakeUp</li>
                        <li class="item" data-tag=".skincare" data-category="adult">Skin Care </li>
                        <li class="item" data-tag=".vitamin" data-category="adult">Vitamin</li>
                        <li class="item" data-tag=".personalcare" data-category="adult">Chăm sóc bản thân</li>
                    </ul>
                </div>
                <div class="product-slider owl-carousel adult">

                    @foreach($featuredProducts['adult'] as $product)
                    @include('front.components.product-item-women')
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<section class="deal-box container-fluid" style="background: rgb(166 246 241);">
    <div class="row">
        <div class="col-lg-6">
            <div class="deal-content text-center">
                <div class="deal-product">
                    <img src="{{ asset('front/img/sale-co-doi-chang-so-don-coi.png') }}" loading="lazy" alt="Ảnh sản phẩm">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <h3 class="recomended_skin">Sản phẩm gợi ý cho loại da của bạn</h3>
            <div class="row">
                @foreach($recommendedProducts as $product)
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="form-card product-item item {{ $product->tag }}">
                        <div class="pi-pic">
                            @foreach($product->productImages as $image)
                            <img src="{{ asset($image->path) }}" alt="{{ $product->name }}">
                            @endforeach
                            @if($product->discount)
                            <div class="sale pp-sale">Giảm giá</div>
                            @endif
                            <div class="icon">
                                <i class="icon_heart_alt"></i>
                            </div>
                            <ul>
                                <li class="w-icon active"><a href="javascript:addCart({{ $product->id }})"><i class="icon_bag_alt"></i></a></li>
                                <li class="quick-view"><a href="shop/product/{{ $product->id }}"><i class="fa fa-search"></i></a></li>
                                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">{{ $product->tag }}</div>
                            <a href="shop/product/{{ $product->id }}">
                                <h5>{{ $product->name }}</h5>
                            </a>
                            <div class="product-price">
                                @if($product->discount)
                                {{ format_price($product->discount) }}
                                <span>{{ format_price($product->price) }}</span>
                                @else
                                <span>{{ format_price($product->price) }}</span>
                                @endif
                            </div>
                            <div class="product-rating">
                                <i class="fa fa-comment"></i>
                                <span>{{ $product->productComments->count() }} đánh giá</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</section>

<!-- Deal off The Week Section Begin -->
<section class="deal-box container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="deal-content text-center">
                <p class="deal-sub">Không phải những người đẹp là những người hạnh phúc, mà những người hạnh phúc mới là những người đẹp.</p>
                <div class="deal-timer" id="countdown">
                    <div class="timer-item">
                        <span>56</span>
                        <small>Ngày</small>
                    </div>
                    <div class="timer-item">
                        <span>12</span>
                        <small>Giờ</small>
                    </div>
                    <div class="timer-item">
                        <span>40</span>
                        <small>Phút</small>
                    </div>
                </div>
                <div class="deal-product">
                    <img class="flash-sale-img" src="{{ asset('front/img/flash-sale.png') }}" loading="lazy" alt="Ảnh sản phẩm">
                </div>

            </div>
        </div>
        <div class="col-lg-6">
            <div class="row deal-gallery">
                <!-- Ảnh to chiếm 8 cột -->
                <div class="col-8 mb-3">
                    <img src="{{ asset('front/img/deal-week1.jpg') }}" loading="lazy" alt="Ảnh 3" class="img-fluid rounded shadow">

                </div>

                <!-- Ảnh nhỏ chiếm 4 cột (xếp dọc) -->
                <div class="col-4 d-flex flex-column">
                    <div class="mb-3">
                        <img src="{{ asset('front/img/deal-week2.jpg') }}" loading="lazy" alt="Ảnh 3" class="img-fluid rounded shadow">
                    </div>
                    <div>
                        <img src="{{ asset('front/img/deal-week3.jpg') }}" loading="lazy" alt="Ảnh 3" class="img-fluid rounded shadow">

                    </div>
                </div>
            </div>
        </div>


    </div>
</section>
<!-- Men Banner Section Begin -->
<section class="man-banner ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <p class="text-lg font-bold best-seller-title ">Xu hướng làm đẹp</p>
                <div class="product-slider owl-carousel child" style="    background-color: #0cbf9a4d;
    padding: 39px 15px 0 15px;
    border-radius: 10px;">
                    @foreach($featuredProducts['child'] as $product)
                    @include('front.components.product-item-men')
                    @endforeach
                </div>

            </div>

        </div>
    </div>
</section>
<!-- Men Banner Section End -->
<section class="man-banner">
    @php
    $viewedIds = session('viewed_products', []);
    $viewedProducts = \App\Models\Product::whereIn('id', $viewedIds)->take(4)->get();
    @endphp

    @if($viewedProducts->count() > 0)
    <div class="related-products spad" style="padding-bottom: 0px;">
        <div class="container">
            <div class="section-title" style="margin-bottom: 0px;">
                <h2 class="add-ons">Sản phẩm bạn đã xem</h2>
            </div>
            <div class="row">
                @foreach($viewedProducts as $product)
                <div class="col-lg-3 col-sm-6">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="{{ optional($product->productImages[0])->path 
            ? asset($product->productImages[0]->path)
            : asset('storage/products/default-product.png') }}" alt="{{ $product->name }}">
                            @if($product->discount)
                            <div class="sale pp-sale">Giảm giá</div>
                            @endif
                            <div class="icon">
                                <i class="icon_heart_alt"></i>
                            </div>
                            <ul>
                                <li class="w-icon active">
                                    <a href="#"><i class="icon_bag_alt"></i></a>
                                </li>
                                <li class="quick-view">
                                    <a href="{{ url('shop/product/' . $product->id) }}" title="Xem sản phẩm">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </li>
                                <li class="w-icon">
                                    <a href="#"><i class="fa fa-random"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">{{ $product->tag }}</div>
                            <a href="{{ url('shop/product/' . $product->id) }}">
                                <h5>{{ $product->name }}</h5>
                            </a>
                            <div class="set-fire flex">
                                <img src="{{ asset('front/img/fire.png') }}">
                                <p class="" style="margin:0; color:white">bán chạy</p>
                            </div>
                            <div class="product-price has-fire">
                                @if ($product->discount)
                                {{ format_price($product->discount) }}
                                <span>{{ format_price($product->price) }}</span>
                                @else
                                <span>{{ format_price($product->price) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</section>


<!-- Lastest Blog Section Begin -->
<section class="latest-blog man-banner" style="    border-bottom: 1px solid #0fd9b1;">
    <div class="row">
        <div class="col-lg-12">
            <div class="section-title text-center mb-4 container">
                <h2 class="fw-bold add-ons ">Tin tức</h2>
                <p class="text-muted">Cập nhật những thông tin mới nhất mỗi ngày</p>
            </div>

        </div>
    </div>
    <div class="row">
        @foreach($blogs as $blog)
        <div class="col-lg-3 col-md-6">
            <div class="single-latest-blog">
                @if($blog->image === 'Null' || empty($blog->image))
                <img src="{{ asset('storage/products/default-product.png') }}" alt="" style="height: 250px;">
                @else
                <img src="{{ asset('storage/blog/' . $blog->image) }}" alt="">
                @endif

                <div class="latest-text">
                    <div class="tag-list">
                        <div class="tag-item">
                            <i class="fa fa-calendar-o"></i>
                            {{date('d M, Y', strtotime($blog->created_at))}}
                        </div>
                        <div class="tag-item">
                            <i class="fa fa-comment-o"></i>
                            {{count($blog->blogComments)}}
                        </div>
                    </div>
                    <a href="">
                        <h4>{{ $blog->title}} </h4>
                    </a>
                    <p>{{$blog->subtitle}} </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="benefit-items">
        <div class="row" style="margin:auto;">
            <div class="col-lg-3">
                <div class="single-benefit">
                    <div class="sb-icon">
                        <img src="/front/img/icon-1.png" alt="">
                    </div>
                    <div class="sb-text">
                        <h6>Giao Hàng Nhanh </h6>
                        <p>Áp dụng cho đơn hàng</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="single-benefit">
                    <div class="sb-icon">
                        <img src="/front/img/icon-2.png" alt="">
                    </div>
                    <div class="sb-text">
                        <h6>Có đổi trả</h6>
                        <p>săn sale hàng tuần</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="single-benefit">
                    <div class="sb-icon">
                        <img src="/front/img/icon-3.png" alt="">
                    </div>
                    <div class="sb-text">
                        <h6>đảm bảo uy tín</h6>
                        <p>Thanh toán & nhận hàng</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="single-benefit">
                    <div class="sb-icon">
                        <img src="/front/img/authentic.png" alt="">
                    </div>
                    <div class="sb-text">
                        <h6>hàng chất lượng </h6>
                        <p>Có sự chọn lọc</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

@endsection
