<!-- Trang Sản Phẩm ở Mục Shop  -->
<div class="col-lg-4 col-sm-6 ">
    <div class="product-item item {{ $product->tag}}">
        <div class="pi-pic">
            <img src="{{ asset(($product->productImages[0]->path ?? 'default-product.png')) }}" alt="{{ $product->name }}">

            @if($product->discount != null)
            <div class="sale pp-sale">Giảm giá</div>
            @endif

            <div class="icon">
                <i class="icon_heart_alt"></i>
            </div>
            <ul>
                <li class="w-icon active"><a href="javascript:addCart({{ $product->id }})"><i class="icon_bag_alt"></i></a></li>
                <li class="quick-view">
                    <a href="shop/product/{{ $product->id }}" title="Xem sản phẩm">
                        <i class="fa fa-search"></i>
                    </a>
                </li>
                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
            </ul>
        </div>
        <div class="pi-text">
            <div class="category-name">{{ $product->tag }}</div>
            <a href="shop/product/{{ $product->id }}">
                <h5>{{ $product->name }}</h5>
            </a>
            <div class="product-price">
                @if( $product->discount != null)
                {{ format_price($product->discount) }}
                <span> {{ format_price($product->price) }}</span>
                @else
                <span>{{ format_price($product->price) }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
