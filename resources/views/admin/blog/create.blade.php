@extends('admin.layout.master')
@section('title', 'Blog')

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
                    Tin tức
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
                <div class="card-body">

                 <form method="post" action="{{ url('admin/blog') }}" enctype="multipart/form-data">
    @csrf

    <div class="position-relative row form-group">
        <label for="title" class="col-md-3 text-md-right col-form-label">Tiêu đề</label>
        <div class="col-md-9 col-xl-8">
            <input required name="title" id="title" placeholder="title" type="text" class="form-control" value="">
        </div>
    </div>

    <div class="position-relative row form-group">
        <label for="subtitle" class="col-md-3 text-md-right col-form-label">Phụ đề</label>
        <div class="col-md-9 col-xl-8">
            <textarea class="form-control" name="subtitle" id="subtitle" placeholder="Subtitle"></textarea>
        </div>
    </div>

    <div class="position-relative row form-group">
        <label for="category" class="col-md-3 text-md-right col-form-label">Danh mục</label>
        <div class="col-md-9 col-xl-8">
            <input required name="category" id="category" placeholder="category" type="text" class="form-control" value="">
        </div>
    </div>

    <div class="position-relative row form-group">
        <label for="content" class="col-md-3 text-md-right col-form-label">Nội dung</label>
        <div class="col-md-9 col-xl-8">
            <textarea class="form-control" name="content" id="content" placeholder="content"></textarea>
        </div>
    </div>

    <!-- Upload ảnh -->
    <div class="position-relative row form-group">
        <label for="image" class="col-md-3 text-md-right col-form-label">Ảnh đại diện</label>
        <div class="col-md-9 col-xl-8">
            <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
            <small class="form-text text-muted">Chỉ chọn file ảnh (jpg, png, jpeg...)</small>
        </div>
    </div>

    <div class="position-relative row form-group mb-1">
        <div class="col-md-9 col-xl-8 offset-md-2">
            <a href="#" class="border-0 btn btn-outline-danger mr-1">
                <span class="btn-icon-wrapper pr-1 opacity-8">
                    <i class="fa fa-times fa-w-20"></i>
                </span>
                <span>Hủy</span>
            </a>

            <button type="submit" class="btn-shadow btn-hover-shine btn btn-primary">
                <span class="btn-icon-wrapper pr-2 opacity-8">
                    <i class="fa fa-download fa-w-20"></i>
                </span>
                <span>Lưu</span>
            </button>
        </div>
    </div>
</form>



                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main -->
@endsection
<!--  CK Editor -->
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        CKEDITOR.replace('content');
    });
</script>