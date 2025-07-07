@extends('layouts.adminLayout.index')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Residents Statistics</h1>
    
    <div class="row">
       
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Gender Distribution</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Civil Status Distribution</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="civilStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Age Group Distribution</h6>
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

    // Civil Status Chart
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

    // Age Group Chart
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
</style>
@endsection