@extends('admin.layout.master')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
@section('title', 'Category')

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
                    Đơn Hàng
                </div>
            </div>
        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-body">
            <div class="table-responsive">
                <h2 class="text-center">Danh Sách Sản Phẩm</h2>

                <button id="openUpdateStatusModal" data-item='@json($order)' class="btn btn-success">
                    <i class="fa-solid fa-pen-to-square me-2"></i>
                    Cập nhật trạng thái
                </button>

                <hr>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Đơn giá</th>
                            <th class="text-center">Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderDetails as $orderDetail)
                        <tr>
                            <td>
                                <img style="height: 60px;" src="{{ asset(($orderDetail->product->productImages[0]->path ?? 'default-product.png')) }}" alt="">
                                {{ $orderDetail->product->name }}
                            </td>
                            <td class="text-center">{{ $orderDetail->qty }}</td>
                            <td class="text-center">{{format_price($orderDetail->amount)}}</td>
                            <td class="text-center">{{format_price($orderDetail->total)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h2 class="text-center mt-5">Chi tiết Đơn hàng</h2>
            <hr>

            <div class="row mb-2">
                <label class="col-md-3 text-md-right col-form-label">Họ tên</label>
                <div class="col-md-9 col-xl-8">
                    <p>{{ $order->first_name }}</p>
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-md-3 text-md-right col-form-label">Email</label>
                <div class="col-md-9 col-xl-8">
                    <p>{{ $order->email }}</p>
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-md-3 text-md-right col-form-label">Điện thoại</label>
                <div class="col-md-9 col-xl-8">
                    <p>{{ $order->phone }}</p>
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-md-3 text-md-right col-form-label">Kiểu thanh toán</label>
                <div class="col-md-9 col-xl-8">
                    <p>{{ $order->payment_type }}</p>
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-md-3 text-md-right col-form-label">Trạng thái</label>
                <div class="col-md-9 col-xl-8">
                    @switch($order->status)
                    @case(0)
                    <span class="badge bg-danger">Hủy đơn hàng</span>
                    @break
                    @case(1)
                    <span class="badge bg-dark">Chờ xác nhận</span>
                    @break
                    @case(2)
                    <span class="badge bg-primary">Xác nhận thành công</span>
                    @break
                    @case(3)
                    <span class="badge bg-warning text-dark">Đang giao</span>
                    @break
                    @case(4)
                    <span class="badge bg-success">Giao hàng thành công</span>
                    @break
                    @endswitch
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-md-3 text-md-right col-form-label">Mô tả</label>
                <div class="col-md-9 col-xl-8">
                    <p>{{ $order->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="updateStatusOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật trạng thái đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form_update_status">
                    <input type="hidden" name="orderId">
                    <div class="mb-3">
                        <label class="form-label">Trạng thái đơn hàng</label>
                        <select name="status" class="form-select" id="statusOrder">
                            <option value="1">Chờ xác nhận</option>
                            <option value="2">Xác nhận thành công</option>
                            <option value="3">Đang giao</option>
                            <option value="4">Giao hàng thành công</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                <button id="btnUpdateStatus" class="btn btn-primary">Cập nhật</button>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Mở modal cập nhật trạng thái đơn hàng
    $('#openUpdateStatusModal').on('click', function(e) {
        e.preventDefault();
        const data = $(this).data('item');

        if (data) {
            $('#statusOrder').val(data.status);
            $('input[name="orderId"]').val(data.id);
            $('#orderCode').text(data.email);
            $('#orderer').text(data.first_name);

            // Hiển thị modal bằng jQuery
            $('#updateStatusOrderModal').modal('show');
        }
    });

    // Khi bấm nút "Cập nhật"
    $('#btnUpdateStatus').on('click', function(e) {
        e.preventDefault();
        const btn = $(this);
        const form = $('#form_update_status')[0];
        const data = new FormData(form);

        Swal.fire({
            title: 'Xác nhận',
            text: 'Bạn có chắc chắn muốn cập nhật trạng thái của đơn hàng này không?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Có, cập nhật',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable button
                btn.text('Đang cập nhật...');
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.order.updateStatus') }}",
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data
                })
                .done(function(res) {
                    if (res.data?.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: res.data.success,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#updateStatusOrderModal').modal('hide');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: res.data?.error || 'Không thể cập nhật trạng thái đơn hàng.'
                        });
                    }
                })
                .fail(function(xhr) {
                    console.error("Lỗi AJAX:", xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi máy chủ',
                        text: xhr.responseJSON?.error || 'Đã xảy ra lỗi trong quá trình cập nhật.'
                    });
                })
                .always(function() {
                    btn.text('Cập nhật');
                    btn.prop('disabled', false);
                });
            }
        });
    });

    // Reset form khi đóng modal
    $('#updateStatusOrderModal').on('hidden.bs.modal', function() {
        $('#form_update_status')[0].reset();
    });
});
</script>

