@extends('backend.layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-3 mb-0">
        <span class="text-muted fw-light">Admin /</span> Dashboard
    </h4>
    <div class="text-muted small">
        <i class="bx bx-calendar me-1"></i>{{ now()->format('d M Y, h:i A') }}
    </div>
</div>

{{-- ── ROW 1: KPI Cards ── --}}
<div class="row g-3 mb-4">

    {{-- Today's Orders --}}
    <div class="col-xl col-md-4 col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small mb-1">Today's orders</p>
                        <h3 class="mb-0 fw-bold">{{ $todayOrders }}</h3>
                    </div>
                    <span class="avatar-initial rounded bg-label-success p-2">
                        <i class="bx bx-cart fs-4"></i>
                    </span>
                </div>
                @if($todayVsYesterday >= 0)
                    <small class="text-success"><i class="bx bx-trending-up"></i> +{{ $todayVsYesterday }}% vs yesterday</small>
                @else
                    <small class="text-danger"><i class="bx bx-trending-down"></i> {{ $todayVsYesterday }}% vs yesterday</small>
                @endif
            </div>
        </div>
    </div>

    {{-- Monthly Revenue --}}
    <div class="col-xl col-md-4 col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small mb-1">Monthly revenue</p>
                        <h3 class="mb-0 fw-bold">৳{{ number_format($thisMonthRevenue, 0) }}</h3>
                    </div>
                    <span class="avatar-initial rounded bg-label-primary p-2">
                        <i class="bx bx-money fs-4"></i>
                    </span>
                </div>
                @if($revenueGrowth >= 0)
                    <small class="text-success"><i class="bx bx-trending-up"></i> +{{ $revenueGrowth }}% vs last month</small>
                @else
                    <small class="text-danger"><i class="bx bx-trending-down"></i> {{ $revenueGrowth }}% vs last month</small>
                @endif
            </div>
        </div>
    </div>

    {{-- Total Customers --}}
    <div class="col-xl col-md-4 col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small mb-1">Total customers</p>
                        <h3 class="mb-0 fw-bold">{{ $totalCustomers }}</h3>
                    </div>
                    <span class="avatar-initial rounded bg-label-info p-2">
                        <i class="bx bx-group fs-4"></i>
                    </span>
                </div>
                <small class="text-success"><i class="bx bx-trending-up"></i> +{{ $newCustomers }} this week</small>
            </div>
        </div>
    </div>

    {{-- Out of Stock --}}
    <div class="col-xl col-md-4 col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small mb-1">Out of stock</p>
                        <h3 class="mb-0 fw-bold">{{ $outOfStock }}</h3>
                    </div>
                    <span class="avatar-initial rounded bg-label-warning p-2">
                        <i class="bx bx-error fs-4"></i>
                    </span>
                </div>
                <small class="text-warning"><i class="bx bx-bell"></i> Restock needed</small>
            </div>
        </div>
    </div>

    {{-- Pending Orders --}}
    <div class="col-xl col-md-4 col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small mb-1">Pending orders</p>
                        <h3 class="mb-0 fw-bold">{{ $pendingOrders }}</h3>
                    </div>
                    <span class="avatar-initial rounded bg-label-danger p-2">
                        <i class="bx bx-time fs-4"></i>
                    </span>
                </div>
                <small class="text-danger"><i class="bx bx-alarm-exclamation"></i> Needs attention</small>
            </div>
        </div>
    </div>

</div>

{{-- ── ROW 2: Sales Chart + Order Status ── --}}
<div class="row g-3 mb-4">

    {{-- Sales Analytics Chart --}}
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bx bx-line-chart me-2"></i>Sales analytics</h5>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-primary active" id="btnWeekly" onclick="switchChart('weekly')">Weekly</button>
                    <button type="button" class="btn btn-outline-primary" id="btnMonthly" onclick="switchChart('monthly')">Monthly</button>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex gap-3 mb-3">
                    <span class="d-flex align-items-center gap-1" style="font-size:12px;color:#696cff">
                        <span style="width:10px;height:10px;background:#696cff;border-radius:2px;display:inline-block"></span> Orders
                    </span>
                    <span class="d-flex align-items-center gap-1" style="font-size:12px;color:#71dd37">
                        <span style="width:10px;height:3px;background:#71dd37;border-radius:2px;display:inline-block"></span> Revenue (৳)
                    </span>
                </div>
                <div style="position:relative;height:240px">
                    <canvas id="salesChart" role="img" aria-label="Sales analytics bar and line chart">Sales data by period.</canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Status --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-pie-chart-alt me-2"></i>Order status</h5>
            </div>
            <div class="card-body">
                <div style="position:relative;height:150px">
                    <canvas id="donutChart" role="img" aria-label="Donut chart of order status">
                        Pending: {{ $orderStatus['pending'] }}, Confirmed: {{ $orderStatus['confirmed'] }}, Delivered: {{ $orderStatus['delivered'] }}, Cancelled: {{ $orderStatus['cancelled'] }}.
                    </canvas>
                </div>
                <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center mb-3" style="font-size:11px">
                    <span><span style="width:8px;height:8px;background:#ff9f43;border-radius:2px;display:inline-block;margin-right:3px"></span>Pending {{ $orderStatus['pending'] }}</span>
                    <span><span style="width:8px;height:8px;background:#696cff;border-radius:2px;display:inline-block;margin-right:3px"></span>Confirmed {{ $orderStatus['confirmed'] }}</span>
                    <span><span style="width:8px;height:8px;background:#71dd37;border-radius:2px;display:inline-block;margin-right:3px"></span>Delivered {{ $orderStatus['delivered'] }}</span>
                    <span><span style="width:8px;height:8px;background:#ff4c51;border-radius:2px;display:inline-block;margin-right:3px"></span>Cancelled {{ $orderStatus['cancelled'] }}</span>
                </div>
                @foreach(['pending' => ['warning','⏳'], 'confirmed' => ['primary','✅'], 'delivered' => ['success','📦'], 'cancelled' => ['danger','❌']] as $status => $meta)
                @php $pct = $totalOrders > 0 ? round(($orderStatus[$status] / $totalOrders) * 100) : 0; @endphp
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div style="width:70px;font-size:12px" class="text-muted text-capitalize">{{ $status }}</div>
                    <div class="progress flex-grow-1" style="height:7px">
                        <div class="progress-bar bg-{{ $meta[0] }}" style="width:{{ $pct }}%"></div>
                    </div>
                    <div style="width:28px;font-size:12px;text-align:right" class="fw-semibold">{{ $orderStatus[$status] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- ── ROW 3: Top Products + Recent Orders + Inventory ── --}}
<div class="row g-3">

    {{-- Top Selling Products --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-trophy me-2"></i>Top selling products</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($topProducts as $i => $item)
                    <li class="list-group-item d-flex align-items-center gap-3 py-3 px-4">
                        <span class="text-muted fw-semibold" style="width:16px;font-size:13px">{{ $i + 1 }}</span>
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" width="34" height="34"
                                 style="border-radius:8px;object-fit:cover;border:1px solid #eee"
                                 onerror="this.style.display='none'">
                        @else
                            <div style="width:34px;height:34px;border-radius:8px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;font-size:16px">
                                <i class="bx bx-package text-muted"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-semibold text-truncate" style="font-size:13px">{{ $item->product_name }}</div>
                            <div class="text-muted" style="font-size:11px">{{ $item->total_qty }} sold</div>
                        </div>
                        <div class="text-success fw-bold" style="font-size:13px;white-space:nowrap">
                            ৳{{ number_format($item->total_revenue, 0) }}
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted py-4">No sales data yet</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bx bx-receipt me-2"></i>Recent orders</h5>
                <a href="{{ route('backend.orders.index') }}" class="btn btn-sm btn-outline-primary">View all</a>
            </div>
            <div class="card-body p-0">
                @forelse($recentOrders as $order)
                @php
                    $badges = ['pending'=>'warning','confirmed'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger'];
                    $badge  = $badges[$order->status] ?? 'secondary';
                    $name   = trim(($order->billing_first_name ?? '') . ' ' . ($order->billing_last_name ?? '')) ?: ($order->user->name ?? 'Unknown');
                @endphp
                <a href="{{ route('backend.orders.show', $order->id) }}" class="d-flex align-items-center gap-3 px-4 py-3 text-decoration-none border-bottom" style="color:inherit">
                    <div class="avatar avatar-sm flex-shrink-0">
                        <span class="avatar-initial rounded-circle bg-label-secondary" style="font-size:11px">
                            {{ strtoupper(substr($name, 0, 2)) }}
                        </span>
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="fw-semibold text-truncate" style="font-size:13px">{{ $name }}</div>
                        <div class="text-muted" style="font-size:11px">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }} · {{ $order->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="text-end flex-shrink-0">
                        <div class="fw-bold text-success" style="font-size:13px">৳{{ number_format($order->total_price, 0) }}</div>
                        <span class="badge bg-label-{{ $badge }}" style="font-size:10px">{{ ucfirst($order->status) }}</span>
                    </div>
                </a>
                @empty
                <div class="text-center text-muted py-4">No orders yet</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Inventory & Finance --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-store me-2"></i>Inventory & finance</h5>
            </div>
            <div class="card-body">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="bg-label-primary rounded p-3 text-center">
                            <div class="fw-bold text-primary" style="font-size:16px">৳{{ number_format($inventoryStats->total_investment ?? 0, 0) }}</div>
                            <div class="text-muted" style="font-size:11px">Total investment</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-label-success rounded p-3 text-center">
                            <div class="fw-bold text-success" style="font-size:16px">৳{{ number_format($inventoryStats->total_sell_value ?? 0, 0) }}</div>
                            <div class="text-muted" style="font-size:11px">Sell value</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-label-info rounded p-3 text-center">
                            <div class="fw-bold text-info" style="font-size:16px">৳{{ number_format($inventoryStats->total_profit ?? 0, 0) }}</div>
                            <div class="text-muted" style="font-size:11px">Potential profit</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-label-warning rounded p-3 text-center">
                            <div class="fw-bold text-warning" style="font-size:16px">{{ round($inventoryStats->avg_margin ?? 0, 1) }}%</div>
                            <div class="text-muted" style="font-size:11px">Avg margin</div>
                        </div>
                    </div>
                </div>

                <hr class="my-3">

                <p class="text-muted fw-semibold mb-2" style="font-size:12px">
                    <i class="bx bx-bell text-danger me-1"></i>Low stock alerts
                </p>
                @forelse($lowStockItems as $item)
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="text-truncate" style="font-size:13px;max-width:65%">{{ $item->name }}</div>
                    <span class="badge {{ $item->stock == 0 ? 'bg-label-danger' : 'bg-label-warning' }}">
                        {{ $item->stock == 0 ? 'Out' : $item->stock . ' left' }}
                    </span>
                </div>
                @empty
                <div class="text-success" style="font-size:13px"><i class="bx bx-check-circle me-1"></i>All items in stock</div>
                @endforelse

                <a href="{{ route('backend.inventory.index') }}" class="btn btn-outline-secondary btn-sm w-100 mt-3">
                    <i class="bx bx-store me-1"></i>View inventory
                </a>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
const weeklyData = {
    labels:  @json(collect($weeklySales)->pluck('label')),
    orders:  @json(collect($weeklySales)->pluck('orders')),
    revenue: @json(collect($weeklySales)->pluck('revenue')),
};
const monthlyData = {
    labels:  @json(collect($monthlySales)->pluck('label')),
    orders:  @json(collect($monthlySales)->pluck('orders')),
    revenue: @json(collect($monthlySales)->pluck('revenue')),
};

const gridColor = 'rgba(0,0,0,0.05)';
const tickColor = '#a1acb8';

const salesChart = new Chart(document.getElementById('salesChart'), {
    type: 'bar',
    data: {
        labels: weeklyData.labels,
        datasets: [
            {
                label: 'Orders',
                data: weeklyData.orders,
                backgroundColor: 'rgba(105,108,255,0.75)',
                borderRadius: 5,
                borderSkipped: false,
                yAxisID: 'y',
            },
            {
                label: 'Revenue (৳)',
                data: weeklyData.revenue,
                type: 'line',
                borderColor: '#71dd37',
                backgroundColor: 'rgba(113,221,55,0.08)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#71dd37',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                borderWidth: 2.5,
                yAxisID: 'y2',
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#566a7f',
                bodyColor: '#566a7f',
                borderColor: '#e7e7e7',
                borderWidth: 1,
                padding: 12,
                cornerRadius: 8,
                callbacks: {
                    label: ctx => ctx.datasetIndex === 0
                        ? ' Orders: ' + ctx.raw
                        : ' Revenue: ৳' + Number(ctx.raw).toLocaleString()
                }
            }
        },
        scales: {
            x: { grid: { color: gridColor }, ticks: { color: tickColor, font: { size: 11 } } },
            y: {
                grid: { color: gridColor },
                ticks: { color: tickColor, font: { size: 11 } },
                beginAtZero: true,
                title: { display: true, text: 'Orders', color: tickColor, font: { size: 10 } }
            },
            y2: {
                position: 'right',
                grid: { display: false },
                ticks: { color: '#71dd37', font: { size: 11 }, callback: v => '৳' + (v >= 1000 ? (v/1000).toFixed(0)+'k' : v) },
                beginAtZero: true,
            }
        }
    }
});

function switchChart(mode) {
    const d = mode === 'weekly' ? weeklyData : monthlyData;
    salesChart.data.labels              = d.labels;
    salesChart.data.datasets[0].data   = d.orders;
    salesChart.data.datasets[1].data   = d.revenue;
    salesChart.update();

    document.getElementById('btnWeekly').classList.toggle('active', mode === 'weekly');
    document.getElementById('btnMonthly').classList.toggle('active', mode === 'monthly');
}

new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Confirmed', 'Shipped', 'Delivered', 'Cancelled'],
        datasets: [{
            data: [
                {{ $orderStatus['pending'] }},
                {{ $orderStatus['confirmed'] }},
                {{ $orderStatus['shipped'] }},
                {{ $orderStatus['delivered'] }},
                {{ $orderStatus['cancelled'] }},
            ],
            backgroundColor: ['#ff9f43','#696cff','#03c3ec','#71dd37','#ff4c51'],
            borderWidth: 0,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#566a7f',
                bodyColor: '#566a7f',
                borderColor: '#e7e7e7',
                borderWidth: 1,
                cornerRadius: 8,
            }
        }
    }
});
</script>
@endpush