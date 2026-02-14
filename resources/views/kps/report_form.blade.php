@extends('layouts.adminLayout.index')

@section('content')
<div class="panel">
    <div class="flex items-center justify-between mb-5">
        <h5 class="font-semibold text-lg dark:text-white-light">KP Cases Monthly Trend</h5>
    </div>
    
    <div class="mb-5 bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="kpCasesChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h5 class="font-semibold text-lg dark:text-white-light mb-3">Nature of Disputes</h5>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="natureChart"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h5 class="font-semibold text-lg dark:text-white-light mb-3">Mode of Settlement</h5>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="settlementChart"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h5 class="font-semibold text-lg dark:text-white-light mb-3">Action Taken</h5>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="actionChart"></canvas>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mb-5">
        <h5 class="font-semibold text-lg dark:text-white-light">Generate KP Case Report</h5>
    </div>
    <div class="mb-5">
        <form action="{{ route('kp-cases.generate-report') }}" method="GET" target="_blank">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="mb-3">
                    <label class="form-label">Nature of Dispute</label>
                    <select class="form-select w-full" name="nature_of_dispute">
                        <option value="">All</option>
                        <option value="Criminal">Criminal</option>
                        <option value="Civil">Civil</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mode of Settlement</label>
                    <select class="form-select w-full" name="mode_of_settlement">
                        <option value="">All</option>
                        <option value="Mediation">Mediation</option>
                        <option value="Conciliation">Conciliation</option>
                        <option value="Arbitration">Arbitration</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Action Taken</label>
                    <select class="form-select w-full" name="action_taken">
                        <option value="">All</option>
                        <option value="Repudiated">Repudiated</option>
                        <option value="Withdrawn">Withdrawn</option>
                        <option value="Pending">Pending</option>
                        <option value="Dismissed">Dismissed</option>
                        <option value="Certified to file action">Certified to file action</option>
                        <option value="Referred to concerned agencies">Referred to concerned agencies</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="form-label">Date From</label>
                    <input type="date" class="form-control w-full border border-gray-300 rounded-md" name="date_from" required>
                </div>
                <div>
                    <label class="form-label">Date To</label>
                    <input type="date" class="form-control w-full border border-gray-300 rounded-md" name="date_to" required>
                </div>
            </div>
            <div class="flex items-center justify-end">
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </div>
        </form>
    </div>

    <hr class="my-5 border-gray-300 dark:border-gray-700">

    <div class="flex items-center justify-between mb-5">
        <h5 class="font-semibold text-lg dark:text-white-light">Generate KP Compliance Report</h5>
    </div>
    <div class="mb-5">
        <form action="{{ route('kp-cases.generate-compliance-report') }}" method="GET" target="_blank">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="form-label">Date From</label>
                    <input type="date" class="form-control w-full border border-gray-300 rounded-md" name="date_from" required>
                </div>
                <div>
                    <label class="form-label">Date To</label>
                    <input type="date" class="form-control w-full border border-gray-300 rounded-md" name="date_to" required>
                </div>
            </div>
            <div class="flex items-center justify-end">
                <button type="submit" class="btn btn-secondary">Generate Compliance Report</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('kpCasesChart').getContext('2d');
        
        // Gradient for the line chart
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)'); // Blue
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Number of Cases filed',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#3b82f6', // Blue
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3b82f6',
                    pointHoverBackgroundColor: '#3b82f6',
                    pointHoverBorderColor: '#fff',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#64748b'
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(100, 116, 139, 0.1)'
                        },
                        ticks: {
                            color: '#64748b',
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });

        // Nature of Disputes Chart
        const natureCtx = document.getElementById('natureChart').getContext('2d');
        new Chart(natureCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($natureLabels) !!},
                datasets: [{
                    data: {!! json_encode($natureCounts) !!},
                    backgroundColor: [
                        'rgba(244, 63, 94, 0.8)',  // Rose
                        'rgba(16, 185, 129, 0.8)', // Emerald
                        'rgba(245, 158, 11, 0.8)', // Amber
                        'rgba(59, 130, 246, 0.8)', // Blue
                    ],
                    borderColor: 'transparent',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: '#64748b' }
                    }
                }
            }
        });

        // Mode of Settlement Chart
        const settlementCtx = document.getElementById('settlementChart').getContext('2d');
        new Chart(settlementCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($settlementLabels) !!},
                datasets: [{
                    data: {!! json_encode($settlementCounts) !!},
                    backgroundColor: [
                        'rgba(139, 92, 246, 0.8)', // Violet
                        'rgba(6, 182, 212, 0.8)',  // Cyan
                        'rgba(236, 72, 153, 0.8)', // Pink
                        'rgba(14, 165, 233, 0.8)', // Sky
                    ],
                    borderColor: 'transparent',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: '#64748b' }
                    }
                }
            }
        });

        // Action Taken Chart
        const actionCtx = document.getElementById('actionChart').getContext('2d');
        new Chart(actionCtx, {
            type: 'pie', // using pie chart for consistency with settlement chart
            data: {
                labels: {!! json_encode($actionLabels) !!},
                datasets: [{
                    data: {!! json_encode($actionCounts) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderColor: 'transparent',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: '#64748b' }
                    }
                }
            }
        });
    });
</script>
@endsection
