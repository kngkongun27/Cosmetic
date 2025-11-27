<form action="{{ request()->segment(2) == 'product' ? 'shop' : ''}}">
    <div class="filter-widget">
        <h4 class="fw-title">Danh Mục</h4>
        <ul class="filter-catagories">

            @foreach($categories as $category)
            <li><a href="shop/category/{{ $category->name}}">{{ $category->name }}</a></li>
            @endforeach

        </ul>
    </div>
    <div class="filter-widget">
        <h4 class="fw-title">Thương Hiệu</h4>
        <div class="fw-brand-check">

            @foreach($brands as $brand)
            <div class="bc-item">
                <label for="bc-{{ $brand->id }}">
                    {{ $brand->name }}
                    <input type="checkbox" {{ (request("brand")[$brand->id] ?? '') == 'on' ? 'checked' :''}} id="bc-{{ $brand->id }}" name="brand[{{ $brand->id }}]" onchange="this.form.submit();">

                    <span class="checkmark"></span>
                </label>
            </div>
            @endforeach
        </div>
    </div>
    <!-- <div class="filter-widget">
        <h4 class="fw-title">Giá</h4>
        <div class="filter-range-wrap">
            <div class="range-slider">
                <div class="price-input">
                    <input type="text" id="minamount">
                    <input type="text" id="maxamount">
                </div>
                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="33" data-max="98">
                    <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>

                </div>

            </div>
        </div>
        <a href="#" class="filter-btn">Lọc Sản Phẩm</a>
    </div>
    <div class="filter-widget">
        <h4 class="fw-title">Màu sắc</h4>
        <div class="fw-color-choose">
            <div class="cs-item">
                <input type="radio" id="cs-black">
                <label for="cs-black" class="cs-black">đen</label>
            </div>
            <div class="cs-item">
                <input type="radio" id="cs-violet">
                <label for="cs-violet" class="cs-violet">tím</label>
            </div>
            <div class="cs-item">
                <input type="radio" id="cs-blue">
                <label for="cs-blue" class="cs-blue">xanh</label>
            </div>
            <div class="cs-item">
                <input type="radio" id="cs-yellow">
                <label for="cs-yellow" class="cs-yellow">vàng</label>
            </div>
          
        </div>
    </div>
    <div class="filter-widget">
        <h4 class="fw-title">Size</h4>
        <div class="fw-size-choose">
            <div class="sc-item">
                <input type="radio" id="s-size">
                <label for="s-size">s</label>
            </div>
            <div class="sc-item">
                <input type="radio" id="m-size">
                <label for="m-size">m</label>
            </div>
            <div class="sc-item">
                <input type="radio" id="l-size">
                <label for="l-size">l</label>
            </div>
            <div class="sc-item">
                <input type="radio" id="xs-size">
                <label for="xs-size">xs</label>
            </div>

        </div>
    </div>
    <div class="filter-widget">
        <h4 class="fw-title">Thẻ</h4>
        <div class="fw-tags">
            <a href="#">Mũ</a>
            <a href="#">Phụ Kiện</a>
            <a href="#">Quần Áo</a>
            <a href="#">Túi Xách</a>
          
        </div>
    </div> -->
  
</form>