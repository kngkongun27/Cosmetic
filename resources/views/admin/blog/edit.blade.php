@extends('admin.layout.master')
@section('title', 'Edit Blog')

@section('body')

<!-- Main -->
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-news-paper icon-gradient bg-mean-fruit"></i>
                </div>
                <div>
                    Chỉnh sửa bài viết
                    <div class="page-title-subheading">
                        Cập nhật thông tin và hình ảnh cho bài viết.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form method="POST" action="{{ url('admin/blog/' . $blog->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Tiêu đề --}}
                        <div class="position-relative row form-group">
                            <label for="title" class="col-md-3 text-md-right col-form-label">Tiêu đề</label>
                            <div class="col-md-9 col-xl-8">
                                <input required name="title" id="title" type="text" class="form-control"
                                    placeholder="Nhập tiêu đề bài viết" value="{{ old('title', $blog->title) }}">
                            </div>
                        </div>

                        {{-- Mô tả ngắn / subtitle --}}
                        <div class="position-relative row form-group">
                            <label for="subtitle" class="col-md-3 text-md-right col-form-label">Tóm tắt</label>
                            <div class="col-md-9 col-xl-8">
                                <textarea class="form-control" name="subtitle" id="subtitle" rows="3" placeholder="Nhập tóm tắt">{{ old('subtitle', $blog->subtitle) }}</textarea>
                            </div>
                        </div>

                        {{-- Nội dung bài viết --}}
                        <div class="position-relative row form-group">
                            <label for="content" class="col-md-3 text-md-right col-form-label">Nội dung</label>
                            <div class="col-md-9 col-xl-8">
                                <textarea class="form-control" name="content" id="content" rows="6" placeholder="Nhập nội dung bài viết">{{ old('content', $blog->content) }}</textarea>
                            </div>
                        </div>

                        {{-- Danh mục --}}
                        <div class="position-relative row form-group">
                            <label for="category" class="col-md-3 text-md-right col-form-label">Danh mục</label>
                            <div class="col-md-9 col-xl-8">
                                <input type="text" name="category" id="category" class="form-control"
                                    placeholder="Nhập danh mục" value="{{ old('category', $blog->category) }}">
                            </div>
                        </div>

                        {{-- Ảnh đại diện --}}
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label">Ảnh bài viết</label>
                            <div class="col-md-9 col-xl-8">
                                <div style="width: 250px; height: 180px; overflow: hidden; border-radius: 6px;">
                                    <img id="preview-image"
                                         src="{{ asset('storage/blog/' . ($blog->image ?? 'default-blog.png')) }}"
                                         alt="Blog Image"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>

                                <div class="mt-2">
                                    <input type="file" name="image" accept="image/*" class="form-control-file"
                                           onchange="previewImage(event)">
                                </div>
                            </div>
                        </div>

                        {{-- Nút hành động --}}
                        <div class="position-relative row form-group mb-1">
                            <div class="col-md-9 col-xl-8 offset-md-3">
                                <a href="{{ url('admin/blog') }}" class="border-0 btn btn-outline-danger mr-1">
                                    <span class="btn-icon-wrapper pr-1 opacity-8">
                                        <i class="fa fa-times fa-w-20"></i>
                                    </span>
                                    <span>Hủy</span>
                                </a>

                                <button type="submit" class="btn-shadow btn-hover-shine btn btn-primary">
                                    <span class="btn-icon-wrapper pr-2 opacity-8">
                                        <i class="fa fa-save fa-w-20"></i>
                                    </span>
                                    <span>Lưu thay đổi</span>
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

{{-- CKEditor + Preview --}}
@section('scripts')
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        CKEDITOR.replace('content');
        CKEDITOR.replace('subtitle');
    });

    function previewImage(event) {
        const output = document.getElementById('preview-image');
        output.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
@endsection
