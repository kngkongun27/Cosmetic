{{-- Sản phẩm ở Silde trang chủ --}}
<div class="product-item item {{ $product->tag}}" style="width:200px;">
    <div class="pi-pic">
        <img src="{{ asset($product->productImages[0]->path ?? 'storage/products/default-product.png') }}" alt="Product Image">

        @if($product->discount != null)
        <div class="sale">Giảm giá</div>
        @endif
        <div class="icon">
            <i class="ti-heart"></i>
        </div>
        <ul>
            <li class="w-icon active"><a href=""><i class="icon_bag_alt"></i></a></li>
            <li class="quick-view">
                <a href="shop/product/{{ $product->id }}" title="Xem sản phẩm">
                    <i class="fa fa-search"></i>
                </a>
            </li>
            <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
        </ul>
    </div>
    <div class="pi-text">
        <div class="catagory-name">{{$product->tag}}</div>
        <a href="shop/product/{{ $product->id }}">
            <h5 title="{{$product->name}}">{{$product->name}}</h5>
        </a>
        <div class="product-price">

            @if ($product->discount != null)
            {{ format_price($product->discount) }}
            <span>{{ format_price($product->price) }}</span>

            @else
            <span style="text-decoration:none;">{{ format_price($product->price) }}</span>
            @endif
        </div>
    </div>
</div>
