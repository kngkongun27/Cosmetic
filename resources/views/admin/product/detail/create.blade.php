@extends('admin.layout.master')
@section('title', 'Product')

@section('body')

<!-- Main -->
<div class="app-main__inner">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                </div>
                <div>
                    Chi tiết sản phẩm
                    <div class="page-title-subheading">
                        .
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">


                    <form method="post" action="admin/product/{{ $product->id }}/detail" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        {{-- Tên sản phẩm --}}
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label">Tên sản phẩm</label>
                            <div class="col-md-9 col-xl-8">
                                <input disabled type="text" class="form-control" value="{{ $product->name }}">
                            </div>
                        </div>


                        {{-- MAKEUP – chọn màu --}}
                        @if(strtolower($product->tag) === 'makeup')
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label">Tông màu</label>
                            <div class="col-md-9 col-xl-8">

                                <input type="hidden" name="color" id="selectedColor" required>

                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach(['#ff0000'=>'Đỏ', '#00ff00'=>'Xanh lá', '#0000ff'=>'Xanh dương', '#ffff00'=>'Vàng'] as $hex => $label)
                                    <div class="color-circle" title="{{ $label }}" data-value="{{ $label }}" style="
                        width:32px;
                        height:32px;
                        border-radius:50%;
                        background:{{ $hex }};
                        cursor:pointer;
                        border:2px solid #bbb;
                        margin-right:6px;">
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        @endif


                        {{-- VITAMIN – chọn size --}}
                        @if(strtolower($product->tag) === 'vitamin')
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label">Size</label>
                            <div class="col-md-9 col-xl-8">

                                <input type="hidden" name="size" id="selectedSize" required>

                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach(['S','M','L'] as $sz)
                                    <div class="size-circle" data-size="{{ $sz }}" style="
                        width:40px;
                        height:40px;
                        border:1px solid #bbb;
                        border-radius:6px;
                        cursor:pointer;
                        text-align:center;
                        line-height:38px;
                        margin-right:6px;">
                                        {{ $sz }}
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        @endif


                        {{-- SKINCARE – chọn dung tích --}}
                        @if(strtolower($product->tag) === 'skincare')
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label">Dung tích</label>
                            <div class="col-md-9 col-xl-8">
                                <select name="capacity" class="form-control w-50" required>
                                    <option value="">-- Chọn dung tích --</option>
                                    @foreach([30, 50, 100, 200] as $ml)
                                    <option value="{{ $ml }}">{{ $ml }} ml</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif


                        {{-- Số lượng --}}
                        <div class="position-relative row form-group">
                            <label for="qty" class="col-md-3 text-md-right col-form-label">Số lượng</label>
                            <div class="col-md-9 col-xl-8">
                                <input required name="qty" id="qty" type="number" class="form-control" placeholder="Số lượng">
                            </div>
                        </div>


                        {{-- Buttons --}}
                        <div class="position-relative row form-group mb-1">
                            <div class="col-md-9 col-xl-8 offset-md-2">
                                <a href="#" class="border-0 btn btn-outline-danger mr-1">
                                    <i class="fa fa-times"></i> Hủy
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Lưu
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // chọn màu (makeup)
    document.querySelectorAll('.color-circle').forEach(item => {
        item.addEventListener('click', function() {
            document.getElementById('selectedColor').value = this.dataset.value;
            document.querySelectorAll('.color-circle').forEach(el => el.style.outline = "");
            this.style.outline = "3px solid black";
        });
    });

    // chọn size (vitamin)
    document.querySelectorAll('.size-circle').forEach(item => {
        item.addEventListener('click', function() {
            document.getElementById('selectedSize').value = this.dataset.size;
            document.querySelectorAll('.size-circle').forEach(el => el.style.background = "");
            this.style.background = "#ddd";
        });
    });

</script>

<!-- End Main -->
@endsection
