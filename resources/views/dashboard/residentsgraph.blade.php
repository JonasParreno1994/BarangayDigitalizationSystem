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
    <div class="row">
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
});
</script>

<style>
.chart-bar {
    position: relative;
    height: 300px;
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