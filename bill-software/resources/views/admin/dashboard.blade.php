@extends('layouts.admin')

@section('title','Admin Dashboard')

@section('content')
<style>
    .stat-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(255,255,255,0.2);
    }
    .stat-card-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .stat-card-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }
    .stat-card-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    .stat-card-danger {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }
    .chart-container {
        position: relative;
        height: 300px;
    }
    .activity-item {
        padding: 15px;
        border-left: 3px solid #e9ecef;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    .activity-item:hover {
        border-left-color: #667eea;
        background: #f8f9fa;
        transform: translateX(5px);
    }
    .badge-pulse {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .revenue-trend {
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .card-modern {
        border: none;
        border-radius: 12px;
    }
    .progress-modern {
        height: 8px;
        border-radius: 10px;
    }
</style>

<div class="container-fluid">
    <!-- Welcome Section with Animation -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card card-modern shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Welcome back, {{ auth()->user()->full_name }}! 👋</h4>
                            <p class="mb-0 opacity-75">Here's what's happening with your business today.</p>
                        </div>
                        <div class="d-none d-md-block">
                            <button class="btn btn-light btn-sm me-2">
                                <i class="fas fa-download me-1"></i> Download Report
                            </button>
                            <button class="btn btn-outline-light btn-sm">
                                <i class="fas fa-cog me-1"></i> Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card stat-card stat-card-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 opacity-75">Total Invoices</p>
                            <h2 class="mb-0 fw-bold">1,250</h2>
                            <div class="revenue-trend mt-2">
                                <i class="fas fa-arrow-up"></i>
                                <span>12% from last month</span>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-file-invoice-dollar fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-sm-6">
            <div class="card stat-card stat-card-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 opacity-75">Total Customers</p>
                            <h2 class="mb-0 fw-bold">350</h2>
                            <div class="revenue-trend mt-2">
                                <i class="fas fa-arrow-up"></i>
                                <span>8% from last month</span>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-sm-6">
            <div class="card stat-card stat-card-warning shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 opacity-75">Total Items</p>
                            <h2 class="mb-0 fw-bold">5,600</h2>
                            <div class="revenue-trend mt-2">
                                <i class="fas fa-arrow-up"></i>
                                <span>15% from last month</span>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-sm-6">
            <div class="card stat-card stat-card-danger shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 opacity-75">Total Suppliers</p>
                            <h2 class="mb-0 fw-bold">80</h2>
                            <div class="revenue-trend mt-2">
                                <i class="fas fa-arrow-up"></i>
                                <span>5% from last month</span>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-truck fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card card-modern shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Revenue Overview</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary active">Week</button>
                            <button class="btn btn-outline-secondary">Month</button>
                            <button class="btn btn-outline-secondary">Year</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-modern shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Invoice Status</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 250px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-circle text-success"></i> Paid</span>
                            <span class="fw-bold">65%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-circle text-warning"></i> Pending</span>
                            <span class="fw-bold">25%</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-circle text-danger"></i> Overdue</span>
                            <span class="fw-bold">10%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Invoices -->
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card card-modern shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Invoices</h5>
                        <a href="#" class="btn btn-sm btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#" class="text-decoration-none fw-bold">#INV-001</a></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-primary text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 12px;">JD</div>
                                            <span>John Doe</span>
                                        </div>
                                    </td>
                                    <td class="fw-bold">$500.00</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                    <td>May 20, 2024</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-decoration-none fw-bold">#INV-002</a></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-success text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 12px;">JS</div>
                                            <span>Jane Smith</span>
                                        </div>
                                    </td>
                                    <td class="fw-bold">$1,200.00</td>
                                    <td><span class="badge bg-warning badge-pulse">Pending</span></td>
                                    <td>May 19, 2024</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-decoration-none fw-bold">#INV-003</a></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-warning text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 12px;">SW</div>
                                            <span>Sam Wilson</span>
                                        </div>
                                    </td>
                                    <td class="fw-bold">$850.00</td>
                                    <td><span class="badge bg-danger">Overdue</span></td>
                                    <td>May 15, 2024</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-decoration-none fw-bold">#INV-004</a></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-danger text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 12px;">AB</div>
                                            <span>Alice Brown</span>
                                        </div>
                                    </td>
                                    <td class="fw-bold">$2,100.00</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                    <td>May 18, 2024</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-modern shadow-sm mb-3">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <strong>New customer registered</strong>
                            <small class="text-muted">2h ago</small>
                        </div>
                        <p class="text-muted small mb-0">Alice Johnson joined the platform</p>
                    </div>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <strong>Invoice #INV-001 paid</strong>
                            <small class="text-muted">5h ago</small>
                        </div>
                        <p class="text-muted small mb-0">Payment of $500 received</p>
                    </div>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <strong>New supplier added</strong>
                            <small class="text-muted">1d ago</small>
                        </div>
                        <p class="text-muted small mb-0">Tech Supplies Ltd. added to system</p>
                    </div>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <strong>Low stock alert</strong>
                            <small class="text-muted">2d ago</small>
                        </div>
                        <p class="text-muted small mb-0">5 items need restocking</p>
                    </div>
                </div>
            </div>

            <div class="card card-modern shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Top Products</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Product A</span>
                            <span class="fw-bold">450 sales</span>
                        </div>
                        <div class="progress progress-modern">
                            <div class="progress-bar bg-primary" style="width: 90%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Product B</span>
                            <span class="fw-bold">320 sales</span>
                        </div>
                        <div class="progress progress-modern">
                            <div class="progress-bar bg-success" style="width: 70%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Product C</span>
                            <span class="fw-bold">180 sales</span>
                        </div>
                        <div class="progress progress-modern">
                            <div class="progress-bar bg-warning" style="width: 45%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Product D</span>
                            <span class="fw-bold">90 sales</span>
                        </div>
                        <div class="progress progress-modern">
                            <div class="progress-bar bg-danger" style="width: 25%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Revenue',
                data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Status Doughnut Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Pending', 'Overdue'],
            datasets: [{
                data: [65, 25, 10],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    });
</script>
@endsection