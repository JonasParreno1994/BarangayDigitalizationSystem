@extends('layouts.adminLayout.index')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="display-4 fw-bold text-primary mb-3">
            <i class="bi bi-graph-up"></i> Senior Citizen Prediction Analytics
        </h2>
        <p class="lead text-muted">Visual analysis of future senior citizen trends and demographics</p>
    </div>

    <!-- Year-by-Year Prediction Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="mb-0">
                        <i class="bi bi-graph-up-arrow"></i> 10-Year Prediction Trend
                    </h4>
                    <small>Residents who will turn 60 years old per year</small>
                </div>
                <div class="card-body p-4">
                    <canvas id="yearlyTrendChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly and Purok Breakdown -->
    <div class="row mb-4">
        <!-- Monthly Breakdown -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-month"></i> Monthly Breakdown for {{ $currentYear + 1 }}
                    </h4>
                    <small>Distribution by birth month</small>
                </div>
                <div class="card-body p-4">
                    <canvas id="monthlyChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- By Purok -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <h4 class="mb-0">
                        <i class="bi bi-geo-alt"></i> By Purok for {{ $currentYear + 1 }}
                    </h4>
                    <small>Distribution by geographic area</small>
                </div>
                <div class="card-body p-4">
                    <canvas id="purokChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Statistics Table -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-table"></i> Detailed Statistics
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Year</th>
                                    <th>Residents Turning 60</th>
                                    <th>Born in Year</th>
                                    <th>Planning Priority</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($analytics as $data)
                                <tr>
                                    <td>
                                        <strong>{{ $data['year'] }}</strong>
                                        @if($data['year'] == $currentYear)
                                            <span class="badge bg-warning">Current Year</span>
                                        @elseif($data['year'] == $currentYear + 1)
                                            <span class="badge bg-info">Next Year</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary fs-6">{{ $data['count'] }} residents</span>
                                    </td>
                                    <td>{{ $data['year'] - 60 }}</td>
                                    <td>
                                        @if($data['count'] > 50)
                                            <span class="badge bg-danger">High Priority</span>
                                        @elseif($data['count'] > 20)
                                            <span class="badge bg-warning">Medium Priority</span>
                                        @else
                                            <span class="badge bg-success">Low Priority</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Statistics Table -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar3"></i> Monthly Distribution ({{ $currentYear + 1 }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th class="text-end">Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlyData as $month)
                                <tr>
                                    <td>{{ $month['month_name'] }}</td>
                                    <td class="text-end">
                                        <strong>{{ $month['count'] }}</strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <th>Total</th>
                                    <th class="text-end">{{ array_sum(array_column($monthlyData, 'count')) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purok Statistics Table -->
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-geo-alt-fill"></i> Purok Distribution ({{ $currentYear + 1 }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Purok</th>
                                    <th class="text-end">Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purokData as $purok)
                                <tr>
                                    <td>{{ $purok['purok_name'] }}</td>
                                    <td class="text-end">
                                        <strong>{{ $purok['count'] }}</strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <th>Total</th>
                                    <th class="text-end">{{ array_sum(array_column($purokData, 'count')) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="text-center mb-4">
        <a href="{{ route('special-reports.senior-prediction') }}" class="btn btn-primary btn-lg shadow">
            <i class="bi bi-arrow-left"></i> Back to Prediction Reports
        </a>
        <button onclick="window.print()" class="btn btn-success btn-lg shadow">
            <i class="bi bi-printer"></i> Print Analytics
        </button>
    </div>
</div>

<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

<script>
    // Yearly Trend Chart
    const yearlyCtx = document.getElementById('yearlyTrendChart').getContext('2d');
    const yearlyData = {!! json_encode($analytics) !!};
    
    new Chart(yearlyCtx, {
        type: 'line',
        data: {
            labels: yearlyData.map(d => d.year),
            datasets: [{
                label: 'Residents Turning 60',
                data: yearlyData.map(d => d.count),
                backgroundColor: 'rgba(102, 126, 234, 0.2)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgba(102, 126, 234, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: { size: 14 }
                    }
                },
                title: {
                    display: true,
                    text: 'Predicted Senior Citizens per Year',
                    font: { size: 16, weight: 'bold' }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' residents will turn 60';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5,
                        font: { size: 12 }
                    },
                    title: {
                        display: true,
                        text: 'Number of Residents',
                        font: { size: 14 }
                    }
                },
                x: {
                    ticks: {
                        font: { size: 12 }
                    },
                    title: {
                        display: true,
                        text: 'Year',
                        font: { size: 14 }
                    }
                }
            }
        }
    });

    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = {!! json_encode($monthlyData) !!};
    
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: monthlyData.map(d => d.month_name),
            datasets: [{
                label: 'Residents',
                data: monthlyData.map(d => d.count),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(199, 199, 199, 0.7)',
                    'rgba(83, 102, 255, 0.7)',
                    'rgba(255, 99, 255, 0.7)',
                    'rgba(99, 255, 132, 0.7)',
                    'rgba(255, 192, 203, 0.7)',
                    'rgba(173, 216, 230, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(199, 199, 199, 1)',
                    'rgba(83, 102, 255, 1)',
                    'rgba(255, 99, 255, 1)',
                    'rgba(99, 255, 132, 1)',
                    'rgba(255, 192, 203, 1)',
                    'rgba(173, 216, 230, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Distribution by Birth Month',
                    font: { size: 14, weight: 'bold' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Purok Chart
    const purokCtx = document.getElementById('purokChart').getContext('2d');
    const purokData = {!! json_encode($purokData) !!};
    
    new Chart(purokCtx, {
        type: 'doughnut',
        data: {
            labels: purokData.map(d => d.purok_name),
            datasets: [{
                data: purokData.map(d => d.count),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(199, 199, 199, 0.8)',
                    'rgba(83, 102, 255, 0.8)',
                    'rgba(255, 99, 255, 0.8)',
                    'rgba(99, 255, 132, 0.8)'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: { size: 12 },
                        padding: 10
                    }
                },
                title: {
                    display: true,
                    text: 'Distribution by Purok',
                    font: { size: 14, weight: 'bold' }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>

<style>
@media print {
    .btn { display: none !important; }
}
</style>
@endsection
