@extends('front.layout.master')

@section('title', 'Contact Us')

<style>
    .btn-contact {
        background-color: #0fd9b1;
        color: #fff;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-contact:hover {
        background-color: #0cc09d;
        transform: translateY(-2px);
    }

    .contact-section .card {
        border-top: 4px solid #0fd9b1;
    }

    .form-control:focus {
        border-color: #0fd9b1;
        box-shadow: 0 0 0 0.2rem rgba(15, 217, 177, 0.25);
    }

</style>

@section('body')
<section class="contact-section py-5">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold mb-3" style="color: #0fd9b1;">Liên hệ với chúng tôi</h2>
              
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        @if(session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success'
                                , title: 'Bạn đã gửi liên hệ thành công đến chúng tôi!'
                                , text: '{{ session('
                                success ') }}'
                                , confirmButtonText: 'OK'
                            });

                        </script>
                        @endif

                        @if ($errors->any())
                        <script>
                            let errorMessages = `{!! implode('<br>', $errors->all()) !!}`;
                            Swal.fire({
                                icon: 'error'
                                , title: 'Lỗi'
                                , html: errorMessages
                                , confirmButtonText: 'Đóng'
                            });

                        </script>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Họ và tên</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nhập họ tên của bạn">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập địa chỉ email">
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label fw-semibold">Chủ đề</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Chủ đề liên hệ">
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label fw-semibold">Nội dung</label>
                                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Nhập nội dung tin nhắn"></textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-contact px-5 py-2 fw-semibold" style="background: #0fd9b1;">
                                    Gửi ngay
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 contact-banner">
            <img src="/front/img/right-banner.jpg"></div>
        </div>
    </div>
</section>

@endsection
