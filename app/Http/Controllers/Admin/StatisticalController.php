<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StatisticalController extends Controller
{
    /**
     * Giao diện chính thống kê
     */
    public function index()
    {
        return view('admin.statistical');
    }

    /**
     * Thống kê doanh thu & lợi nhuận theo ngày
     */
    public function getProfit(Request $request)
    {
        $filter = $request->input('filter', 'day');

        switch ($filter) {
            case 'week':
                $groupBy = DB::raw('YEAR(od.created_at), WEEK(od.created_at)');
                $orderBy = DB::raw('YEAR(od.created_at), WEEK(od.created_at)');
                // wrap MIN() để hợp lệ với ONLY_FULL_GROUP_BY
                $selectDate = DB::raw("CONCAT('Tuần ', WEEK(MIN(od.created_at)), ' - ', YEAR(MIN(od.created_at))) as period");
                break;

            case 'month':
                $groupBy = DB::raw('YEAR(od.created_at), MONTH(od.created_at)');
                $orderBy = DB::raw('YEAR(od.created_at), MONTH(od.created_at)');
                $selectDate = DB::raw("CONCAT(MONTH(MIN(od.created_at)), '/', YEAR(MIN(od.created_at))) as period");
                break;

            case 'year':
                $groupBy = DB::raw('YEAR(od.created_at)');
                $orderBy = DB::raw('YEAR(od.created_at)');
                $selectDate = DB::raw("YEAR(MIN(od.created_at)) as period");
                break;

            default: // day (hôm nay)
                $groupBy = null;
                $orderBy = null;
                $selectDate = DB::raw("CURDATE() as period");
                break;
        }

        $query = DB::table('order_details as od')
            ->join('products as p', 'od.product_id', '=', 'p.id')
            ->join('orders as o', 'od.order_id', '=', 'o.id')
            ->where('o.status', 4)
            ->select(
                $selectDate,
                DB::raw('SUM(od.qty * p.price) as totalSell'),
                DB::raw('SUM(od.qty * p.originalPr) as totalBuy')
            );

        if ($filter === 'day') {
            $query->whereDate('od.created_at', today());
        }

        if (!is_null($groupBy)) {
            $query->groupBy($groupBy);
        }

        if (!is_null($orderBy)) {
            $query->orderByRaw($orderBy);
        }

        $results = $query->get();

        $data = $results->map(function ($row) {
            return [
                'period' => $row->period,
                'revenue' => (float)$row->totalSell,
                'profit' => (float)($row->totalSell - $row->totalBuy),
            ];
        });

        return response()->json($data);
    }






    /**
     * Top 5 sản phẩm bán chạy nhất
     */
    public function getTopProducts()
    {
        $topProducts = DB::table('order_details as od')
            ->join('products as p', 'od.product_id', '=', 'p.id')
            ->select(
                'p.id',
                'p.name',
                DB::raw('SUM(od.qty) as total_sold'),
                DB::raw('SUM(od.qty * od.amount) as total_revenue')
            )
            ->groupBy('p.id', 'p.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
        return $topProducts;
        return response()->json($topProducts);
    }

    /**
     * Top khách hàng có doanh thu cao nhất
     */
    public function getTopCustomers()
    {
        $topCustomers = DB::table('orders as o')
            ->join('users as u', 'o.user_id', '=', 'u.id')
            ->join('order_details as od', 'o.id', '=', 'od.order_id')
            ->select(
                'u.id',
                'u.name',
                'u.email',
                DB::raw('SUM(od.total) as total_spent'),
                DB::raw('COUNT(DISTINCT o.id) as order_count')
            )
            ->groupBy('u.id', 'u.name', 'u.email')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $item->formatted_total_spent = format_price($item->total_spent);
                return $item;
            });

        return $topCustomers;
        return response()->json($topCustomers);
    }

    /**
     * Thống kê đơn hàng theo trạng thái
     */
    public function getOrderStatusStats()
    {
        $statusStats = DB::table('orders')
            ->select(
                'status',
                DB::raw('COUNT(*) as total_orders')
            )
            ->groupBy('status')
            ->get();

        return response()->json($statusStats);
    }

    /**
     * Tổng quan nhanh cho dashboard
     */
    public function getOverview()
    {
        $totalRevenue = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->sum(DB::raw('order_details.qty * products.price'));

        $totalProfit = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->sum(DB::raw('(order_details.qty * (products.price - products.originalPr))'));

        $totalOrders = DB::table('orders')->count();
        $totalUsers = DB::table('users')->count();
        $totalProducts = DB::table('products')->count();

        return response()->json([
            'total_revenue' => $totalRevenue,
            'total_profit' => $totalProfit,
            'total_orders' => $totalOrders,
            'total_users' => $totalUsers,
            'total_products' => $totalProducts
        ]);
    }
}
