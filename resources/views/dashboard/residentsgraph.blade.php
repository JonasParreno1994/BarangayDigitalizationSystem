@extends('layouts.adminLayout.index')

@section('content')
<style>
    .custom-title {
  font-size: 28px;
  font-weight: 600;
  font-family:  'Times New Roman', Times, serif;
  color: #343a40; /* dark gray */
  margin-bottom: 1.5rem;
}
    </style>
<div class="container-fluid">
<center><h1 class="custom-title">📊 Data Visualization Graph</h1>
  </center>
    
    <!-- Full width chart for Purok distribution -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <center><h6 class="m-0 font-weight-bold text-primary">Resident Distribution by Purok</h6></center>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="purokChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Side-by-side cards for Gender and Civil Status -->
    <div class="cards-container mb-4">
        <div class="card-wrapper">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                <center>    <h6 class="m-0 font-weight-bold text-primary">Gender Distribution</h6></center>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-wrapper">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                <center>  <h6 class="m-0 font-weight-bold text-primary">Civil Status Distribution</h6></center>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="civilStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Full width chart for Age Group distribution -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                <center>   <h6 class="m-0 font-weight-bold text-primary">Age Group Distribution</h6></center>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="ageGroupChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Senior Citizen Prediction Analytics Section -->
    <center><h2 class="custom-title mt-4 mb-3">👴 Senior Citizen Prediction Analytics</h2></center>
    
    <!-- Year-by-Year Prediction Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <center><h6 class="m-0 font-weight-bold">10-Year Prediction Trend</h6></center>
                    <center><small>Residents who will turn 60 years old per year</small></center>
                </div>
                <div class="card-body">
                    <div class="chart-compact">
                        <canvas id="yearlyTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly and Purok Breakdown -->
    <div class="cards-container mb-4">
        <div class="card-wrapper">
            <div class="card shadow h-100">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <center><h6 class="m-0 font-weight-bold">Monthly Breakdown for {{ $currentYear + 1 }}</h6></center>
                    <center><small>Distribution by birth month</small></center>
                </div>
                <div class="card-body">
                    <div class="chart-compact">
                        <canvas id="seniorMonthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-wrapper">
            <div class="card shadow h-100">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                    <center><h6 class="m-0 font-weight-bold">By Purok for {{ $currentYear + 1 }}</h6></center>
                    <center><small>Distribution by geographic area</small></center>
                </div>
                <div class="card-body">
                    <div class="chart-compact">
                        <canvas id="seniorPurokChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var purokCtx = document.getElementById('purokChart').getContext('2d');
    var purokChart = new Chart(purokCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($purokCounts->keys()) !!},
            datasets: [{
                label: 'Number of Residents',
                data: {!! json_encode($purokCounts->values()) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });

   
    var ctx = document.getElementById('genderChart').getContext('2d');
    var genderChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                label: 'Number of Residents',
                data: [{{ $maleCount }}, {{ $femaleCount }}],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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


    var civilStatusCtx = document.getElementById('civilStatusChart').getContext('2d');
    var civilStatusChart = new Chart(civilStatusCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($civilStatusCounts->keys()) !!},
            datasets: [{
                label: 'Number of Residents',
                data: {!! json_encode($civilStatusCounts->values()) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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

   
    var ageGroupCtx = document.getElementById('ageGroupChart').getContext('2d');
    var ageGroupChart = new Chart(ageGroupCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($ageGroups)) !!},
            datasets: [{
                label: 'Number of Residents',
                data: {!! json_encode(array_values($ageGroups)) !!},
                backgroundColor: 'rgba(153, 102, 255, 0.7)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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

    // Senior Citizen Prediction Analytics Charts
    
    // Yearly Trend Chart
    var yearlyCtx = document.getElementById('yearlyTrendChart').getContext('2d');
    var yearlyData = {!! json_encode($analytics) !!};
    
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
                pointRadius: 4,
                pointHoverRadius: 6,
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
                        font: { size: 12 }
                    }
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
                        font: { size: 11 }
                    }
                },
                x: {
                    ticks: {
                        font: { size: 11 }
                    }
                }
            }
        }
    });

    // Senior Monthly Chart
    var seniorMonthlyCtx = document.getElementById('seniorMonthlyChart').getContext('2d');
    var monthlyData = {!! json_encode($monthlyData) !!};
    
    new Chart(seniorMonthlyCtx, {
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

    // Senior Purok Chart
    var seniorPurokCtx = document.getElementById('seniorPurokChart').getContext('2d');
    var seniorPurokData = {!! json_encode($seniorPurokData) !!};
    
    new Chart(seniorPurokCtx, {
        type: 'doughnut',
        data: {
            labels: seniorPurokData.map(d => d.purok_name),
            datasets: [{
                data: seniorPurokData.map(d => d.count),
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
                        font: { size: 10 },
                        padding: 8
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>

<style>
.chart-bar {
    position: relative;
    height: 300px;
}

.chart-compact {
    position: relative;
    height: 220px;
}


.cards-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0;
    justify-content: center;
}

.card-wrapper {
    flex: 1;
    min-width: 300px;
    max-width: 600px;
}

.card {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    border-radius: 0 !important; 
    margin: 0;
    height: 100%;
}


.card-wrapper:not(:last-child) .card {
    border-right: 1px solid #e3e6f0;
}

.card-wrapper:first-child .card {
    border-top-left-radius: calc(0.35rem - 1px) !important;
    border-bottom-left-radius: calc(0.35rem - 1px) !important;
}

.card-wrapper:last-child .card {
    border-top-right-radius: calc(0.35rem - 1px) !important;
    border-bottom-right-radius: calc(0.35rem - 1px) !important;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    z-index: 10;
}


.card-body {
    position: relative;
    z-index: 2;
}

.card-header {
    position: relative;
    z-index: 2;
}


@media (max-width: 1200px) {
    .card-wrapper {
        max-width: 500px;
    }
}

@media (max-width: 992px) {
    .cards-container {
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .card-wrapper {
        flex: 0 0 100%;
        max-width: none;
    }
    
    .card {
        border-radius: calc(0.35rem - 1px) !important;
        border-right: none !important;
    }
}

@media (max-width: 768px) {
    .card-wrapper {
        min-width: 250px;
    }
}
</style>
@endsection