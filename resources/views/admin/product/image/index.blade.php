@extends('admin.layout.master')
@section('title', 'Product')

@section('body')


<!-- Main -->
<div class="app-main__inner">`

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                </div>
                <div>
                    Ảnh sản phẩm
                    <div class="page-title-subheading">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">

                    <div class="position-relative row form-group">
                        <label for="name" class="col-md-3 text-md-right col-form-label">Tên sản phẩm</label>
                        <div class="col-md-9 col-xl-8">
                            <input disabled placeholder="Tên sản phẩm" type="text" class="form-control" value="{{$product->name}}">
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="" class="col-md-3 text-md-right col-form-label">Ảnh</label>
                        <div class="col-md-9 col-xl-8">
                            <ul class="text-nowrap" id="images">
                                <!-- Hiển thị các ảnh đã upload -->
                                @foreach ($productImages as $productImage)
                                <li style="position: relative; width: 32%; display:inline-block; margin:5px;">
                                    <img src="{{ asset($productImage->path ?? 'default-product.png') }}" style="width:100%; height:200px; object-fit:cover;">

                                    <!-- Form xóa ảnh -->
                                    <form action="{{ route('product.image.destroy', [$product->id, $productImage->id]) }}" method="POST" style="position:absolute; top:5px; right:5px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Bạn có muốn xóa ảnh này?')" class="btn btn-sm btn-danger">X</button>
                                    </form>
                                </li>
                                @endforeach

                                <!-- Form thêm ảnh -->
                                <li style="width:32%; display:inline-block; margin:5px;">
                                    <form method="POST" action="{{ route('product.image.store', $product->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="images[]" multiple style="display:none;" onchange="this.form.submit()" id="imageUpload">
                                        <img src="{{ asset('dashboard/assets/images/add-image-icon.jpg') }}" style="width:100%; height:200px; object-fit:cover; cursor:pointer;" onclick="document.getElementById('imageUpload').click()">
                                    </form>
                                </li>
                            </ul>

                        </div>

                        <div class="position-relative row form-group mb-1">
                            <div class="col-md-9 col-xl-8 offset-md-3">
                                <a href="./admin/product/{{ $product->id }}" class="btn-shadow btn-hover-shine btn btn-primary">
                                    <span class="btn-icon-wrapper pr-2 opacity-8">
                                        <i class="fa fa-check fa-w-20"></i>
                                    </span>
                                    <span>OK</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main -->
    @endsection
