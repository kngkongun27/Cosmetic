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
                    Sản phẩm
                    <div class="page-title-subheading">
                        <!-- View, create, update, delete and manage. -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body display_data">

                    <div class="position-relative row form-group">
                        <label for="" class="col-md-3 text-md-right col-form-label">Ảnh</label>
                        <div class="col-md-9 col-xl-8">



                            <ul class="text-nowrap overflow-auto" id="images">

                                @foreach($product->productImages as $productImage)
                                <li class="d-inline-block mr-1" style="position: relative;">
                                    <img style="height: 150px;" src="{{ asset($productImage->path ?? 'storage/products/default-product.png') }}" alt="Product Image">
                                </li>

                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="brand_id" class="col-md-3 text-md-right col-form-label">Ảnh sản phẩm</label>
                        <div class="col-md-9 col-xl-8">
                            <p><a href="./admin/product/{{ $product->id }}/image">Cập nhật ảnh</a></p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="brand_id" class="col-md-3 text-md-right col-form-label">Chi tiết sản phẩm</label>
                        <div class="col-md-9 col-xl-8">
                            <p><a href="./admin/product/{{ $product->id}}/detail">Quản lý chi tiết sản phẩm</a></p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="brand_id" class="col-md-3 text-md-right col-form-label">Thương hiệu</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $product->brand->name }}</p>
                        </div>
                    </div>


                    <div class="position-relative row form-group">
                        <label for="name" class="col-md-3 text-md-right col-form-label">Tên</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $product->name }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="content" class="col-md-3 text-md-right col-form-label">Nội dung</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $product->content }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="price" class="col-md-3 text-md-right col-form-label">Giá</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ format_price($product->price) }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="discount" class="col-md-3 text-md-right col-form-label">Giảm giá</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ format_price($product->discount) }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="qty" class="col-md-3 text-md-right col-form-label">Số lượng</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $product->qty }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="tag" class="col-md-3 text-md-right col-form-label">Tag</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $product->tag}}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="featured" class="col-md-3 text-md-right col-form-label">Nổi bật</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $product->featured ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="description" class="col-md-3 text-md-right col-form-label">Miêu tả</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{!! $product->description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main -->
@endsection
