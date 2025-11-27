@extends('front.layout.master')

@section('title', 'Product')

@section('body')
<style>
    .color-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid #ddd;
        transition: 0.2s;
    }

    .color-circle:hover {
        transform: scale(1.1);
        border-color: #333;
    }

</style>
<!-- Star Main Product -->
<section id="hura" class="product-shop spad page-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 ">
                @include('front.shop.components.products-sidebar-filter')
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="product-pic-zoom">
                            <img class="product-big-img" src="{{ isset($product->productImages[0]) ? asset($product->productImages[0]->path) : asset('storage/products/default-product.png') }}" alt="{{ $product->name }}">
                            <div class="zoom-icon">
                                <i class="fa fa-search-plus"></i>
                            </div>
                        </div>

                        <div class="product-thumbs">
                            <div class="product-thumbs-track ps-slider owl-carousel">
                                @foreach($product->productImages as $productImage)
                                <div class="pt" data-imgbigurl="{{ asset($productImage->path) }}">
                                    <img src="{{ asset($productImage->path) }}" alt="{{ $product->name }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="product-details">
                            <div class="pd-title">
                                <span>{{ $product->tag }}</span>
                                <h3>{{ $product->name }}</h3>
                                <a href="#" class="heart-icon"><i class="icon_heart_alt"></i></a>
                            </div>
                            <div class="pd-rating">

                                @for($i = 1; $i <= 5 ; $i++) @if($i <=$product->avgRating)
                                    <i class="fa fa-star"></i>
                                    @else
                                    <i class="fa fa-star-o"></i>
                                    <span>({{ count($product->productComments) }})</span>
                                    @endif
                                    @endfor
                            </div>
                            <div class="pd-desc">
                                <p>{{ $product->content}} </p>

                                @if ($product->discount != null)
                                <h4> {{ format_price($product->discount) }}<span>{{ format_price($product->price) }}</span></h4>
                                @else
                                <h4>{{ format_price($product->price) }}</h4>
                                @endif
                            </div>
                            @php
                            $totalQuantity = $product->productDetails->sum('qty');
                            @endphp

                            <div>Kho: {{ $totalQuantity }}</div>


                            <div class="pd-size-choose">
                                @foreach(array_unique(array_column($product->productDetails->toArray(), 'size')) as $productSize)
                                <div class="sc-item">
                                    <input type="radio" id="sm-{{ $productSize}}">
                                    <label for="sm-{{ $productSize}}">{{ $productSize}}</label>
                                </div>
                                @endforeach
                            </div>
                            {{-- Chỉ hiển thị bảng màu nếu là sản phẩm Makeup --}}
                            {{-- Makeup chọn màu --}}
                            @if(strtolower($product->tag) === 'makeup')
                            <div class="pd-color-choose mt-3 mb-3">
                                <label><strong>Chọn tông màu:</strong></label>
                                <div class="color-options d-flex gap-2 mt-2">
                                    <div class="color-circle" style="background-color: #B22222;" title="Đỏ quyến rũ"></div>
                                    <div class="color-circle" style="background-color: #D47C73;" title="Hồng đất"></div>
                                    <div class="color-circle" style="background-color: #C65D3D;" title="Cam đất"></div>
                                    <div class="color-circle" style="background-color: #800020;" title="Đỏ rượu vang"></div>

                                </div>
                            </div>
                            @endif

                            @if(strtolower($product->tag) === 'vitamin')
                            <div class="pd-size-choose mt-3 mb-3">
                                <label><strong>Chọn size:</strong></label>
                                <div class="size-options d-flex gap-2 mt-2">
                                    <div class="size-circle" data-size="S">S</div>
                                    <div class="size-circle" data-size="L">L</div>
                                </div>
                            </div>
                            @endif

                            {{-- Skin care chọn dung tích --}}
                            @if(strtolower($product->tag) === 'skincare')
                            <div class="pd-volume-choose mt-3 mb-3">
                                <label><strong>Chọn dung tích (ml):</strong></label>
                                <select class="form-control w-50" id="volumeSelect">
                                    @foreach([30, 50, 100, 200] as $ml)
                                    <option value="{{ $ml }}">{{ $ml }} ml</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" value="1">
                                </div>
                                <a href="javascript:addCart({{ $product->id }}, {{ $totalQuantity }})" class="primary-btn pd-cart">+ Giỏ hàng </a>
                            </div>
                            <ul class="pd-tags">
                                <li><span>Thẻ</span>: {{ $product->tag }}</li>
                            </ul>
                            <div class="pd-share">
                                <div class="pd-social">
                                    <a href="#"><i class="ti-facebook"></i></a>
                                    <a href="#"><i class="ti-twitter-alt"></i></a>
                                    <a href="#"><i class="ti-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-tab">
                    <div class="tab-item">
                        <ul class="nav" role="tablist">
                            <li><a class="active" href="#tab-1" data-toggle="tab" role="tab">Mô Tả</a></li>
                            <li><a href="#tab-2" data-toggle="tab" role="tab">Chi Tiết Sản Phẩm</a></li>
                            <li><a href="#tab-3" data-toggle="tab" role="tab">Đánh Giá ({{ count($product->productComments) }})</a></li>
                        </ul>
                    </div>
                    <div class="tab-item-content">
                        <div class="tab-content">
                            <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                <div class="product-content">
                                    {!! $product->description !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                <div class="specification-table">
                                    <table>
                                        <tr>
                                            <td class="p-catagory">Khách Hàng Đánh Giá</td>
                                            <td>
                                                <div class="pd-rating">
                                                    @for( $i = 1; $i <= 5; $i++) @if($i <=$product->avgRating)
                                                        <i class="fa  fa-star"></i>
                                                        @else
                                                        <i class="fa  fa-star-o"></i>
                                                        @endif
                                                        @endfor
                                                        <span>({{ count($product->productComments)}})</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-catagory">Giá</td>
                                            <td>
                                                <div class="p-price">
                                                    {{ format_price($product->price) }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-catagory">Thêm vào giỏ hàng</td>
                                            <td>
                                                <div class="cart-add">+add to cart</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-catagory">Trong Kho</td>
                                            <td>
                                                <div class="p-stock"> {{ $product->qty }}</div>
                                            </td>
                                        </tr>


                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                <div class="customer-review-option">
                                    <h4> {{ count($product->productComments)}} Bình luận</h4>
                                    <div class="comment-option">
                                        @foreach($product->productComments as $productComment)
                                        <div class="co-item">
                                            <div class="avatar-pic">
                                                <img src="front/img/user/{{ $productComment->user->avatar ?? 'default-avatarr.jpg'}}" alt="">
                                            </div>
                                            <div class="avatar-text">
                                                <div class="at-rating">
                                                    @for($i = 1; $i <= 5; $i++) @if($i <=$productComment->rating)
                                                        <i class="fa fa-star"></i>
                                                        @else
                                                        <i class="fa fa-star-o"></i>
                                                        @endif
                                                        @endfor
                                                </div>
                                                l <h5>{{$productComment->name}}<span>{{ date('M d, Y', strtotime($productComment->created_at)) }}</span></h5>
                                                <div class="at-reply">{{ $productComment->messages }}</div>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>

                                    <div class="leave-comment">
                                        <h4>Để lại đánh giá</h4>
                                        <form action="" method="post" class="comment-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id}}">
                                            <input type="hidden" name="user_id" value="{{ \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->id : null }}">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="text" placeholder="Name" name="name">
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" placeholder="Email" name="email">
                                                </div>
                                                <div class="col-lg-12">
                                                    <textarea placeholder="Messages" name="messages"></textarea>

                                                    <div class="personal-rating">
                                                        <h6>Đánh Giá Của Bạn</h6>
                                                        <div class="rate">
                                                            <input type="radio" id="star5" name="rating" value="5" />
                                                            <label for="star5" title="text">5 stars</label>
                                                            <input type="radio" id="star4" name="rating" value="4" />
                                                            <label for="star4" title="text">4 stars</label>
                                                            <input type="radio" id="star3" name="rating" value="3" />
                                                            <label for="star3" title="text">3 stars</label>
                                                            <input type="radio" id="star2" name="rating" value="2" />
                                                            <label for="star2" title="text">2 stars</label>
                                                            <input type="radio" id="star1" name="rating" value="1" />
                                                            <label for="star1" title="text">1 star</label>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="site-btn">Gửi phản hồi</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Product Start -->
<div class="related-products spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Sản phẩm liên quan</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($relatedProducts as $product)
            @include('front.components.product-item-related')
            @endforeach
        </div>
    </div>
</div>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>




<script>
    const app = Vue.createApp({
        data() {
            return {
                listComment: [],

                searchQuery: '',

            };
        }
        , mounted() {
            axios.get('/comment')
                .then(response => {
                    this.listComment = response.data;
                    console.log(this.listComment);
                })
        }
        , methods: {


        }
        , computed: {
            // filteredItems() {
            //     if (this.searchQuery === '') {
            //         return this.tenbaiviet;
            //     } else {
            //         return this.tenbaiviet.filter(item => item.title.toLowerCase().includes(this.searchQuery.toLowerCase()));
            //     }
            // },


        }
    , });

    const vueInstace = app.mount("#hura");

</script>
@endsection
