@extends('layouts.adminLayout.index')

@section('content')
<div class="analytics-page">
    <!-- Animated Background -->
    <div class="page-bg"></div>
    
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <a href="{{ route('special-reports.senior-prediction') }}" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back to Prediction</span>
            </a>
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
            </div>
            <h1 class="page-title">Prediction Analytics</h1>
            <p class="page-subtitle">Visual analysis of future senior citizen trends and demographics</p>
        </div>
        <div class="header-decoration">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
        </div>
    </div>

    <!-- Summary Cards -->
    @php
        $totalNextYear = array_sum(array_column($monthlyData, 'count'));
        $totalPredicted = array_sum(array_column($analytics, 'count'));
        $avgPerYear = round($totalPredicted / count($analytics));
        $peakYear = collect($analytics)->sortByDesc('count')->first();
    @endphp
    
    <div class="summary-cards">
        <div class="summary-card" style="animation-delay: 0.1s">
            <div class="summary-icon icon-blue">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="summary-content">
                <span class="summary-value">{{ $totalNextYear }}</span>
                <span class="summary-label">Next Year ({{ $currentYear + 1 }})</span>
            </div>
        </div>
        
        <div class="summary-card" style="animation-delay: 0.2s">
            <div class="summary-icon icon-emerald">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
            </div>
            <div class="summary-content">
                <span class="summary-value">{{ $totalPredicted }}</span>
                <span class="summary-label">10-Year Total</span>
            </div>
        </div>
        
        <div class="summary-card" style="animation-delay: 0.3s">
            <div class="summary-icon icon-amber">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="20" x2="12" y2="10"></line>
                    <line x1="18" y1="20" x2="18" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="16"></line>
                </svg>
            </div>
            <div class="summary-content">
                <span class="summary-value">{{ $avgPerYear }}</span>
                <span class="summary-label">Avg. Per Year</span>
            </div>
        </div>
        
        <div class="summary-card" style="animation-delay: 0.4s">
            <div class="summary-icon icon-rose">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
            <div class="summary-content">
                <span class="summary-value">{{ $peakYear['year'] }}</span>
                <span class="summary-label">Peak Year ({{ $peakYear['count'] }})</span>
            </div>
        </div>
    </div>

    <!-- Main Trend Chart -->
    <div class="chart-section main-chart" style="animation-delay: 0.5s">
        <div class="chart-header">
            <div class="chart-title-wrap">
                <div class="chart-icon gradient-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                </div>
                <div>
                    <h3 class="chart-title">10-Year Prediction Trend</h3>
                    <p class="chart-subtitle">Residents who will turn 60 years old per year</p>
                </div>
            </div>
            <div class="chart-legend">
                <span class="legend-dot"></span>
                <span>Projected Seniors</span>
            </div>
        </div>
        <div class="chart-body">
            <canvas id="yearlyTrendChart"></canvas>
        </div>
    </div>

    <!-- Two Column Charts -->
    <div class="charts-row">
        <!-- Monthly Breakdown -->
        <div class="chart-section" style="animation-delay: 0.6s">
            <div class="chart-header">
                <div class="chart-title-wrap">
                    <div class="chart-icon gradient-rose">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <h3 class="chart-title">Monthly Distribution</h3>
                        <p class="chart-subtitle">For year {{ $currentYear + 1 }}</p>
                    </div>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Purok Distribution -->
        <div class="chart-section" style="animation-delay: 0.7s">
            <div class="chart-header">
                <div class="chart-title-wrap">
                    <div class="chart-icon gradient-emerald">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 class="chart-title">Purok Distribution</h3>
                        <p class="chart-subtitle">Geographic breakdown</p>
                    </div>
                </div>
            </div>
            <div class="chart-body chart-body-donut">
                <canvas id="purokChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Data Tables Section -->
    <div class="tables-section" style="animation-delay: 0.8s">
        <div class="section-header">
            <div class="section-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="3" y1="9" x2="21" y2="9"></line>
                    <line x1="3" y1="15" x2="21" y2="15"></line>
                    <line x1="9" y1="3" x2="9" y2="21"></line>
                </svg>
            </div>
            <div class="section-title-wrap">
                <h2 class="section-title">Detailed Statistics</h2>
                <p class="section-desc">Comprehensive data breakdown for planning and analysis</p>
            </div>
        </div>

        <!-- Year-by-Year Table -->
        <div class="data-table-card">
            <div class="table-card-header">
                <h4>Year-by-Year Projection</h4>
                <span class="table-badge">{{ count($analytics) }} Years</span>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Residents Turning 60</th>
                            <th>Birth Year</th>
                            <th>Planning Priority</th>
                            <th>Trend</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($analytics as $index => $data)
                        <tr class="{{ $data['year'] == $currentYear ? 'row-highlight-current' : ($data['year'] == $currentYear + 1 ? 'row-highlight-next' : '') }}">
                            <td>
                                <div class="year-cell">
                                    <strong>{{ $data['year'] }}</strong>
                                    @if($data['year'] == $currentYear)
                                        <span class="year-badge badge-amber">Current</span>
                                    @elseif($data['year'] == $currentYear + 1)
                                        <span class="year-badge badge-blue">Next</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="count-cell">
                                    <span class="count-value">{{ $data['count'] }}</span>
                                    <span class="count-label">residents</span>
                                </div>
                            </td>
                            <td class="birth-year">{{ $data['year'] - 60 }}</td>
                            <td>
                                @if($data['count'] > 50)
                                    <span class="priority-badge priority-high">
                                        <span class="priority-dot"></span>
                                        High Priority
                                    </span>
                                @elseif($data['count'] > 20)
                                    <span class="priority-badge priority-medium">
                                        <span class="priority-dot"></span>
                                        Medium
                                    </span>
                                @else
                                    <span class="priority-badge priority-low">
                                        <span class="priority-dot"></span>
                                        Low
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($index > 0)
                                    @php
                                        $prevCount = $analytics[$index - 1]['count'];
                                        $diff = $data['count'] - $prevCount;
                                    @endphp
                                    @if($diff > 0)
                                        <span class="trend-indicator trend-up">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="18 15 12 9 6 15"></polyline>
                                            </svg>
                                            +{{ $diff }}
                                        </span>
                                    @elseif($diff < 0)
                                        <span class="trend-indicator trend-down">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                            {{ $diff }}
                                        </span>
                                    @else
                                        <span class="trend-indicator trend-neutral">—</span>
                                    @endif
                                @else
                                    <span class="trend-indicator trend-neutral">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Distribution Tables Row -->
        <div class="tables-row">
            <!-- Monthly Table -->
            <div class="data-table-card table-card-half">
                <div class="table-card-header">
                    <h4>Monthly Distribution ({{ $currentYear + 1 }})</h4>
                    <span class="table-badge badge-rose">12 Months</span>
                </div>
                <div class="table-wrapper">
                    <table class="data-table table-compact">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th class="text-right">Count</th>
                                <th class="text-right">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $monthTotal = array_sum(array_column($monthlyData, 'count')); @endphp
                            @foreach($monthlyData as $month)
                            <tr>
                                <td>
                                    <div class="month-cell">
                                        <span class="month-indicator" style="background: hsl({{ ($month['month'] - 1) * 30 }}, 70%, 60%);"></span>
                                        {{ $month['month_name'] }}
                                    </div>
                                </td>
                                <td class="text-right">
                                    <strong>{{ $month['count'] }}</strong>
                                </td>
                                <td class="text-right">
                                    <span class="percentage">{{ $monthTotal > 0 ? round(($month['count'] / $monthTotal) * 100, 1) : 0 }}%</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td class="text-right"><strong>{{ $monthTotal }}</strong></td>
                                <td class="text-right"><strong>100%</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Purok Table -->
            <div class="data-table-card table-card-half">
                <div class="table-card-header">
                    <h4>Purok Distribution ({{ $currentYear + 1 }})</h4>
                    <span class="table-badge badge-emerald">{{ count($purokData) }} Puroks</span>
                </div>
                <div class="table-wrapper">
                    <table class="data-table table-compact">
                        <thead>
                            <tr>
                                <th>Purok</th>
                                <th class="text-right">Count</th>
                                <th class="text-right">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $purokTotal = array_sum(array_column($purokData, 'count')); @endphp
                            @foreach($purokData as $index => $purok)
                            <tr>
                                <td>
                                    <div class="purok-cell">
                                        <span class="purok-indicator" style="background: hsl({{ $index * 36 }}, 70%, 60%);"></span>
                                        {{ $purok['purok_name'] }}
                                    </div>
                                </td>
                                <td class="text-right">
                                    <strong>{{ $purok['count'] }}</strong>
                                </td>
                                <td class="text-right">
                                    <span class="percentage">{{ $purokTotal > 0 ? round(($purok['count'] / $purokTotal) * 100, 1) : 0 }}%</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td class="text-right"><strong>{{ $purokTotal }}</strong></td>
                                <td class="text-right"><strong>100%</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Footer -->
    <div class="action-footer" style="animation-delay: 0.9s">
        <a href="{{ route('special-reports.senior-prediction') }}" class="action-btn btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Back to Prediction</span>
        </a>
        <button onclick="window.print()" class="action-btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                <rect x="6" y="14" width="12" height="8"></rect>
            </svg>
            <span>Print Analytics</span>
        </button>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Color palette
    const colors = {
        primary: '#3b82f6',
        primaryLight: '#60a5fa',
        violet: '#8b5cf6',
        emerald: '#10b981',
        amber: '#f59e0b',
        rose: '#f43f5e',
        gray: '#64748b'
    };
    
    const gradientColors = [
        '#3b82f6', '#8b5cf6', '#f43f5e', '#f59e0b', '#10b981',
        '#06b6d4', '#ec4899', '#84cc16', '#f97316', '#6366f1',
        '#14b8a6', '#eab308'
    ];

    // Yearly Trend Chart
    const yearlyCtx = document.getElementById('yearlyTrendChart').getContext('2d');
    const yearlyData = {!! json_encode($analytics) !!};
    
    const yearlyGradient = yearlyCtx.createLinearGradient(0, 0, 0, 300);
    yearlyGradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
    yearlyGradient.addColorStop(1, 'rgba(59, 130, 246, 0.02)');
    
    new Chart(yearlyCtx, {
        type: 'line',
        data: {
            labels: yearlyData.map(d => d.year),
            datasets: [{
                label: 'Residents Turning 60',
                data: yearlyData.map(d => d.count),
                backgroundColor: yearlyGradient,
                borderColor: colors.primary,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 9,
                pointBackgroundColor: '#fff',
                pointBorderColor: colors.primary,
                pointBorderWidth: 3,
                pointHoverBackgroundColor: colors.primary,
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    titleFont: { size: 14, weight: '600' },
                    bodyFont: { size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return 'Year ' + context[0].label;
                        },
                        label: function(context) {
                            return context.parsed.y + ' residents will turn 60';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 12, weight: '500' },
                        color: colors.gray,
                        padding: 10
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 12, weight: '600' },
                        color: colors.gray,
                        padding: 10
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
            labels: monthlyData.map(d => d.month_name.substring(0, 3)),
            datasets: [{
                label: 'Residents',
                data: monthlyData.map(d => d.count),
                backgroundColor: gradientColors.slice(0, 12),
                borderRadius: 6,
                borderSkipped: false,
                barThickness: 24
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    titleFont: { size: 14, weight: '600' },
                    bodyFont: { size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        title: function(context) {
                            const fullMonths = monthlyData.map(d => d.month_name);
                            return fullMonths[context[0].dataIndex];
                        },
                        label: function(context) {
                            return context.parsed.y + ' residents';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 11, weight: '500' },
                        color: colors.gray,
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 11, weight: '600' },
                        color: colors.gray
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
                backgroundColor: gradientColors.slice(0, purokData.length),
                borderColor: '#fff',
                borderWidth: 3,
                hoverBorderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: { size: 12, weight: '500' },
                        color: colors.gray,
                        padding: 12,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    titleFont: { size: 14, weight: '600' },
                    bodyFont: { size: 13 },
                    padding: 12,
                    cornerRadius: 8,
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
/* ===== CSS Variables ===== */
:root {
    --an-primary: #0f172a;
    --an-primary-light: #1e293b;
    --an-accent: #3b82f6;
    --an-accent-light: #60a5fa;
    --an-violet: #8b5cf6;
    --an-emerald: #10b981;
    --an-amber: #f59e0b;
    --an-rose: #f43f5e;
    --an-gray-50: #f8fafc;
    --an-gray-100: #f1f5f9;
    --an-gray-200: #e2e8f0;
    --an-gray-300: #cbd5e1;
    --an-gray-400: #94a3b8;
    --an-gray-500: #64748b;
    --an-gray-600: #475569;
    --an-gray-700: #334155;
    --an-gray-800: #1e293b;
    --an-gray-900: #0f172a;
    --an-radius: 16px;
    --an-radius-sm: 10px;
    --an-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --an-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
}

/* ===== Page Container ===== */
.analytics-page {
    position: relative;
    min-height: 100vh;
    padding: 2rem;
    font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* ===== Animated Background ===== */
.page-bg {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(ellipse at 0% 0%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
        radial-gradient(ellipse at 100% 0%, rgba(139, 92, 246, 0.08) 0%, transparent 50%),
        radial-gradient(ellipse at 100% 100%, rgba(16, 185, 129, 0.05) 0%, transparent 50%),
        radial-gradient(ellipse at 0% 100%, rgba(245, 158, 11, 0.05) 0%, transparent 50%);
    pointer-events: none;
    z-index: -1;
}

/* ===== Header Section ===== */
.page-header {
    position: relative;
    text-align: center;
    padding: 3rem 2rem;
    margin-bottom: 2rem;
    background: linear-gradient(135deg, var(--an-primary) 0%, var(--an-primary-light) 100%);
    border-radius: var(--an-radius);
    overflow: hidden;
    animation: fadeInDown 0.6s ease-out;
}

.header-content {
    position: relative;
    z-index: 2;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--an-gray-300);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
    transition: color 0.2s ease;
}

.back-link:hover {
    color: white;
}

.header-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--an-accent) 0%, var(--an-violet) 100%);
    border-radius: 20px;
    margin-bottom: 1.5rem;
    color: white;
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
}

.page-title {
    font-size: 2.25rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.75rem;
    letter-spacing: -0.02em;
}

.page-subtitle {
    font-size: 1rem;
    color: var(--an-gray-300);
    margin: 0;
}

.header-decoration {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}

.floating-shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
}

.shape-1 {
    width: 300px;
    height: 300px;
    background: var(--an-accent);
    top: -100px;
    right: -50px;
    animation: float 8s ease-in-out infinite;
}

.shape-2 {
    width: 200px;
    height: 200px;
    background: var(--an-violet);
    bottom: -50px;
    left: 10%;
    animation: float 6s ease-in-out infinite reverse;
}

.shape-3 {
    width: 150px;
    height: 150px;
    background: var(--an-emerald);
    top: 20%;
    left: -30px;
    animation: float 7s ease-in-out infinite 1s;
}

/* ===== Summary Cards ===== */
.summary-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 2rem;
}

@media (max-width: 1200px) {
    .summary-cards { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
    .summary-cards { grid-template-columns: 1fr; }
}

.summary-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    background: white;
    border-radius: var(--an-radius-sm);
    border: 1px solid var(--an-gray-200);
    animation: fadeInUp 0.6s ease-out backwards;
    transition: all 0.3s ease;
}

.summary-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--an-shadow-lg);
}

.summary-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    border-radius: 12px;
    flex-shrink: 0;
}

.icon-blue { background: rgba(59, 130, 246, 0.15); color: var(--an-accent); }
.icon-emerald { background: rgba(16, 185, 129, 0.15); color: var(--an-emerald); }
.icon-amber { background: rgba(245, 158, 11, 0.15); color: var(--an-amber); }
.icon-rose { background: rgba(244, 63, 94, 0.15); color: var(--an-rose); }

.summary-content {
    display: flex;
    flex-direction: column;
}

.summary-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--an-gray-900);
    line-height: 1;
}

.summary-label {
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--an-gray-500);
    margin-top: 0.25rem;
}

/* ===== Chart Sections ===== */
.chart-section {
    background: white;
    border-radius: var(--an-radius);
    border: 1px solid var(--an-gray-200);
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out backwards;
}

.main-chart {
    margin-bottom: 1.5rem;
}

.main-chart .chart-body {
    height: 320px;
}

.charts-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 992px) {
    .charts-row { grid-template-columns: 1fr; }
}

.chart-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--an-gray-100);
}

.chart-title-wrap {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.chart-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    color: white;
}

.gradient-blue { background: linear-gradient(135deg, var(--an-accent) 0%, var(--an-violet) 100%); }
.gradient-rose { background: linear-gradient(135deg, var(--an-rose) 0%, #fb7185 100%); }
.gradient-emerald { background: linear-gradient(135deg, var(--an-emerald) 0%, #34d399 100%); }

.chart-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--an-gray-800);
    margin: 0;
}

.chart-subtitle {
    font-size: 0.8rem;
    color: var(--an-gray-500);
    margin: 0;
}

.chart-legend {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--an-gray-500);
}

.legend-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--an-accent);
}

.chart-body {
    padding: 1.5rem;
    height: 280px;
}

.chart-body-donut {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ===== Tables Section ===== */
.tables-section {
    background: white;
    border-radius: var(--an-radius);
    border: 1px solid var(--an-gray-200);
    overflow: hidden;
    margin-bottom: 2rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 2rem;
    background: var(--an-gray-50);
    border-bottom: 1px solid var(--an-gray-200);
}

.section-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--an-accent) 0%, var(--an-violet) 100%);
    border-radius: 12px;
    color: white;
}

.section-title-wrap { flex: 1; }

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--an-gray-900);
    margin: 0 0 0.25rem;
}

.section-desc {
    font-size: 0.9rem;
    color: var(--an-gray-500);
    margin: 0;
}

.data-table-card {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--an-gray-100);
}

.data-table-card:last-child {
    border-bottom: none;
}

.table-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.table-card-header h4 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--an-gray-800);
    margin: 0;
}

.table-badge {
    display: inline-flex;
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    background: var(--an-gray-100);
    color: var(--an-gray-600);
    border-radius: 20px;
}

.badge-rose { background: rgba(244, 63, 94, 0.1); color: var(--an-rose); }
.badge-emerald { background: rgba(16, 185, 129, 0.1); color: var(--an-emerald); }

.tables-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0;
}

@media (max-width: 992px) {
    .tables-row { grid-template-columns: 1fr; }
}

.table-card-half {
    border-bottom: none;
}

.table-card-half:first-child {
    border-right: 1px solid var(--an-gray-100);
}

@media (max-width: 992px) {
    .table-card-half:first-child {
        border-right: none;
        border-bottom: 1px solid var(--an-gray-100);
    }
}

.table-wrapper {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 0.875rem 1rem;
    text-align: left;
    border-bottom: 1px solid var(--an-gray-100);
}

.data-table th {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--an-gray-500);
    background: var(--an-gray-50);
}

.data-table td {
    font-size: 0.875rem;
    color: var(--an-gray-700);
}

.data-table tbody tr:hover {
    background: var(--an-gray-50);
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

.table-compact th,
.table-compact td {
    padding: 0.625rem 0.75rem;
}

.data-table tfoot tr {
    background: var(--an-gray-50);
}

.data-table tfoot td {
    font-weight: 600;
    color: var(--an-gray-800);
    border-bottom: none;
}

.text-right { text-align: right; }

.row-highlight-current {
    background: rgba(245, 158, 11, 0.05);
}

.row-highlight-next {
    background: rgba(59, 130, 246, 0.05);
}

.year-cell {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.year-badge {
    display: inline-flex;
    padding: 0.2rem 0.5rem;
    font-size: 0.65rem;
    font-weight: 600;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.badge-amber { background: rgba(245, 158, 11, 0.15); color: var(--an-amber); }
.badge-blue { background: rgba(59, 130, 246, 0.15); color: var(--an-accent); }

.count-cell {
    display: flex;
    align-items: baseline;
    gap: 0.35rem;
}

.count-value {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--an-accent);
}

.count-label {
    font-size: 0.75rem;
    color: var(--an-gray-400);
}

.birth-year {
    color: var(--an-gray-500);
}

.priority-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.65rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 20px;
}

.priority-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.priority-high {
    background: rgba(244, 63, 94, 0.1);
    color: var(--an-rose);
}
.priority-high .priority-dot { background: var(--an-rose); }

.priority-medium {
    background: rgba(245, 158, 11, 0.1);
    color: var(--an-amber);
}
.priority-medium .priority-dot { background: var(--an-amber); }

.priority-low {
    background: rgba(16, 185, 129, 0.1);
    color: var(--an-emerald);
}
.priority-low .priority-dot { background: var(--an-emerald); }

.trend-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8rem;
    font-weight: 600;
}

.trend-up { color: var(--an-emerald); }
.trend-down { color: var(--an-rose); }
.trend-neutral { color: var(--an-gray-400); }

.month-cell,
.purok-cell {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.month-indicator,
.purok-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.percentage {
    font-size: 0.8rem;
    color: var(--an-gray-400);
}

/* ===== Action Footer ===== */
.action-footer {
    display: flex;
    justify-content: center;
    gap: 1rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: var(--an-radius-sm);
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, var(--an-accent) 0%, var(--an-violet) 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
}

.btn-secondary {
    background: white;
    color: var(--an-gray-700);
    border: 2px solid var(--an-gray-200);
}

.btn-secondary:hover {
    background: var(--an-gray-50);
    border-color: var(--an-gray-300);
    color: var(--an-gray-800);
}

/* ===== Animations ===== */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

/* ===== Dark Mode Support ===== */
.dark .analytics-page {
    --an-gray-50: #1e293b;
    --an-gray-100: #334155;
    --an-gray-200: #475569;
    --an-gray-300: #64748b;
    --an-gray-400: #94a3b8;
    --an-gray-500: #cbd5e1;
    --an-gray-600: #e2e8f0;
    --an-gray-700: #f1f5f9;
    --an-gray-800: #f8fafc;
    --an-gray-900: #ffffff;
}

.dark .summary-card,
.dark .chart-section,
.dark .tables-section {
    background: var(--an-primary-light);
    border-color: var(--an-gray-200);
}

.dark .section-header {
    background: rgba(0, 0, 0, 0.2);
}

.dark .data-table th {
    background: rgba(0, 0, 0, 0.2);
}

.dark .data-table tfoot tr {
    background: rgba(0, 0, 0, 0.2);
}

.dark .btn-secondary {
    background: var(--an-primary-light);
    border-color: var(--an-gray-200);
    color: var(--an-gray-300);
}

/* ===== Print Styles ===== */
@media print {
    .page-bg,
    .header-decoration,
    .action-footer,
    .back-link {
        display: none !important;
    }
    
    .analytics-page {
        padding: 0;
    }
    
    .page-header {
        background: none !important;
        color: black !important;
        padding: 1rem 0;
        margin-bottom: 1rem;
    }
    
    .page-title,
    .page-subtitle {
        color: black !important;
    }
    
    .header-icon {
        display: none;
    }
    
    .summary-cards,
    .charts-row {
        break-inside: avoid;
    }
    
    .chart-section,
    .tables-section {
        box-shadow: none;
        border: 1px solid #ddd;
    }
}

/* ===== Responsive Adjustments ===== */
@media (max-width: 768px) {
    .analytics-page {
        padding: 1rem;
    }
    
    .page-header {
        padding: 2rem 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .section-header {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    
    .table-card-header {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }
    
    .action-footer {
        flex-direction: column;
    }
    
    .action-btn {
        width: 100%;
        justify-content: center;
    }
    
    .data-table-card {
        padding: 1rem;
    }
}
</style>
@endsection
