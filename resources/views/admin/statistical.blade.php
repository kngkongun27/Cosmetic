@extends('admin.layout.master')
@section('title', 'Thống kê doanh thu')

@section('body')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<style>
    body {
        background: #f4f6f9;
    }

    .card {
        border-radius: 14px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
    }

    .chart-container {
        height: 400px;
    }

    .stat-card {
        border-left: 5px solid;
        transition: 0.2s;
    }

</style>

<section class="content-header">
    <div class="container-fluid">
        <h1><i class="fa-solid fa-chart-line"></i> Thống kê bán hàng tổng hợp</h1>
    </div>
</section>

<section class="content" id="app">
    <div class="container-fluid">

        <!-- Tổng quan -->
        <div class="row mb-4">
            <div class="col-md-3" v-for="(summary, index) in ordersSummary" :key="index">
                <div class="card stat-card text-center" :class="summary.color">
                    <div class="card-body">
                        <i :class="summary.icon + ' fa-2x mb-2'"></i>
                        <h5>@{{ summary.title }}</h5>
                        <h3 class="text-primary">@{{ summary.value }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fa-solid fa-chart-column"></i> Biểu đồ doanh thu & lợi nhuận</h3>

                <div class="d-flex gap-2">
                    <select v-model="filterType" class="form-control form-control-sm" @change="loadData">
                        <option value="day">Theo ngày</option>
                        <option value="week">Theo tuần</option>
                        <option value="month">Theo tháng</option>
                        <option value="year">Theo năm</option>
                    </select>

                    <button class="btn btn-light btn-sm" @click="loadData">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Chart -->
                    <div class="col-lg-8">
                        <div class="chart-container">
                            <canvas id="chartRevenue"></canvas>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="col-lg-4">
                        <table class="table table-bordered text-center">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Thời gian</th>
                                    <th>Doanh thu</th>
                                    <th>Lợi nhuận</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(date, index) in arrDate" :key="index">
                                    <td>@{{ index + 1 }}</td>
                                    <td>@{{ date }}</td>
                                    <td class="text-success fw-bold">@{{ formatCurrency(arrDoanhThu[index]) }}</td>
                                    <td class="text-primary fw-bold">@{{ formatCurrency(arrLoiNhuan[index]) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <small class="text-muted">Cập nhật lần cuối: @{{ lastUpdated }}</small>
            </div>
        </div>

        <!-- Top sản phẩm -->
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <i class="fa-solid fa-box"></i> Top 10 sản phẩm bán chạy
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên</th>
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in topProducts" :key="index">
                                    <td>@{{ index + 1 }}</td>
                                    <td>@{{ item.name }}</td>
                                    <td class="text-success fw-bold">@{{ item.total_sold }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Top khách hàng -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-warning">
                        <i class="fa-solid fa-user"></i> Top 10 khách chi tiêu cao nhất
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in topCustomers" :key="index">
                                    <td>@{{ index + 1 }}</td>
                                    <td>@{{ item.name }}</td>
                                    <td class="text-danger fw-bold">@{{ item.formatted_total_spent }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


{{-- Vue --}}
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    new Vue({
        el: '#app'
        , data: {
            arrDate: []
            , arrDoanhThu: []
            , arrLoiNhuan: []
            , filterType: 'day'
            , chartInstance: null
            , lastUpdated: ''
            , topProducts: []
            , topCustomers: []
            , ordersSummary: []
        , },

        mounted() {
            this.loadData();
            this.loadTopProducts();
            this.loadTopCustomers();
            this.loadOrdersSummary();
        },

        methods: {
            loadData() {
                axios.get(`{{ route('admin.statistical.profit') }}?filter=${this.filterType}`)
                    .then(res => {
                        const data = res.data;

                        this.arrDate = data.map(d => {
                            if (this.filterType === 'day') {
                                return moment(d.period).format("DD/MM/YYYY");
                            }
                            return d.period;
                        });

                        this.arrDoanhThu = data.map(d => d.revenue);
                        this.arrLoiNhuan = data.map(d => d.profit);

                        this.lastUpdated = moment().format("HH:mm:ss DD/MM/YYYY");

                        this.drawChart();
                    });
            },

            loadTopProducts() {
                axios.get('{{ route("admin.statistical.topProducts") }}')
                    .then(res => this.topProducts = res.data);
            },

            loadTopCustomers() {
                axios.get('{{ route("admin.statistical.topCustomers") }}')
                    .then(res => this.topCustomers = res.data);
            },

            loadOrdersSummary() {
                axios.get('{{ route("admin.statistical.ordersSummary") }}')
                    .then(res => {
                        const colors = ['bg-blue', 'bg-green', 'bg-yellow', 'bg-red'];
                        const icons = ['fa-truck', 'fa-check', 'fa-clock', 'fa-ban'];

                        this.ordersSummary = res.data.summary.map((s, i) => ({
                            title: 'Trạng thái: ' + s.status
                            , value: s.count
                            , color: colors[i % colors.length]
                            , icon: icons[i % icons.length]
                        }));

                        this.ordersSummary.push({
                            title: 'Tổng đơn hàng'
                            , value: res.data.totalOrders
                            , color: 'bg-blue'
                            , icon: 'fa-layer-group'
                        });
                    });
            },

            drawChart() {
                const ctx = document.getElementById('chartRevenue');

                if (this.chartInstance) this.chartInstance.destroy();

                this.chartInstance = new Chart(ctx, {
                    type: 'line'
                    , data: {
                        labels: this.arrDate
                        , datasets: [{
                                label: "Doanh thu"
                                , data: this.arrDoanhThu
                                , borderColor: 'rgba(75, 192, 192, 1)', // màu xanh ngọc
                                backgroundColor: 'rgba(75, 192, 192, 0.2)', // màu nền (mờ)
                                fill: true
                                , tension: 0.4
                            }
                            , {
                                label: "Lợi nhuận"
                                , data: this.arrLoiNhuan
                                , borderColor: 'rgba(255, 99, 132, 1)', // màu đỏ
                                backgroundColor: 'rgba(255, 99, 132, 0.2)', // màu nền (mờ)
                                fill: true
                                , tension: 0.4
                            }
                        ]

                    }
                    , options: {
                        responsive: true
                        , maintainAspectRatio: false
                    , }
                });
            },

            formatCurrency(val) {
                const amount = Number(val) * 1000;
                return amount.toLocaleString('vi-VN') + ' đ';
            }
        }
    });

</script>

@endsection
