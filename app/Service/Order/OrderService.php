<?php

namespace   App\Service\Order;

use Exception;
use App\Models\Order;
use App\Service\BaseService;
use Illuminate\Support\Facades\Log;
use App\Service\Order\OrderServiceInterface;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderService extends BaseService implements OrderServiceInterface
{
    public $repository;

    public function __construct(OrderRepositoryInterface $OrderRepository)
    {
        $this->repository = $OrderRepository;
    }
    public function getOrderByUserId($userId)
    {
        return $this->repository->getOrderByUserId(($userId));
    }

    /**
     * Hàm cập nhật trạng thái đơn hàng
     */
    public function updateStatusOrder($request)
    {
        try {
            $newStatus = $request->status;
            $order = Order::findOrFail($request->orderId);

            $order->status = $newStatus;
            $order->save();

            return ['success' => 'Cập nhật trạng thái đơn hàng thành công'];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['error' => 'Đã có lỗi xảy ra, vui lòng thử lại sau'];
        }
    }
}
