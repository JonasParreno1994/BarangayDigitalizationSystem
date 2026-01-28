@extends('layouts.adminLayout.index')

@section('content')
<div class="graph-page">
    <!-- Animated Background -->
    <div class="page-bg"></div>
    
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
            </div>
            <h1 class="page-title">Data Visualization</h1>
            <p class="page-subtitle">Comprehensive resident demographics and analytics dashboard</p>
        </div>
        <div class="header-decoration">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
        </div>
    </div>

    <!-- Quick Stats Summary -->
    @php
        $totalResidents = $maleCount + $femaleCount;
        $totalPuroks = $purokCounts->count();
    @endphp
    <div class="quick-stats" style="animation-delay: 0.1s">
        <div class="stat-item">
            <div class="stat-icon icon-blue">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-data">
                <span class="stat-value">{{ number_format($totalResidents) }}</span>
                <span class="stat-label">Total Residents</span>
            </div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-icon icon-emerald">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="stat-data">
                <span class="stat-value">{{ number_format($maleCount) }}</span>
                <span class="stat-label">Male</span>
            </div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-icon icon-rose">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="stat-data">
                <span class="stat-value">{{ number_format($femaleCount) }}</span>
                <span class="stat-label">Female</span>
            </div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-icon icon-amber">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
            <div class="stat-data">
                <span class="stat-value">{{ $totalPuroks }}</span>
                <span class="stat-label">Puroks</span>
            </div>
        </div>
    </div>

    <!-- Section: Population Demographics -->
    <div class="section-divider" style="animation-delay: 0.15s">
        <div class="divider-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
        </div>
        <span class="divider-text">Population Demographics</span>
        <div class="divider-line"></div>
    </div>

    <!-- Purok Distribution Chart (Full Width) -->
    <div class="chart-card full-width" style="animation-delay: 0.2s">
        <div class="chart-header">
            <div class="chart-title-wrap">
                <div class="chart-icon gradient-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <div>
                    <h3 class="chart-title">Resident Distribution by Purok</h3>
                    <p class="chart-subtitle">Population count per geographic area</p>
                </div>
            </div>
            <div class="chart-badge badge-blue">{{ $totalPuroks }} Puroks</div>
        </div>
        <div class="chart-body chart-body-lg">
            <canvas id="purokChart"></canvas>
        </div>
    </div>

    <!-- Gender & Civil Status (Side by Side) -->
    <div class="charts-row" style="animation-delay: 0.3s">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title-wrap">
                    <div class="chart-icon gradient-emerald">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 8v8"></path>
                            <path d="M8 12h8"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="chart-title">Gender Distribution</h3>
                        <p class="chart-subtitle">Male vs Female residents</p>
                    </div>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="genderChart"></canvas>
            </div>
            <div class="chart-footer">
                <div class="footer-stat">
                    <span class="footer-dot dot-blue"></span>
                    <span>Male: {{ number_format($maleCount) }} ({{ $totalResidents > 0 ? round(($maleCount / $totalResidents) * 100, 1) : 0 }}%)</span>
                </div>
                <div class="footer-stat">
                    <span class="footer-dot dot-rose"></span>
                    <span>Female: {{ number_format($femaleCount) }} ({{ $totalResidents > 0 ? round(($femaleCount / $totalResidents) * 100, 1) : 0 }}%)</span>
                </div>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title-wrap">
                    <div class="chart-icon gradient-violet">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 class="chart-title">Civil Status Distribution</h3>
                        <p class="chart-subtitle">Marital status breakdown</p>
                    </div>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="civilStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Age Group Distribution (Full Width) -->
    <div class="chart-card full-width" style="animation-delay: 0.4s">
        <div class="chart-header">
            <div class="chart-title-wrap">
                <div class="chart-icon gradient-amber">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                </div>
                <div>
                    <h3 class="chart-title">Age Group Distribution</h3>
                    <p class="chart-subtitle">Population by age brackets</p>
                </div>
            </div>
            <div class="chart-badge badge-amber">{{ count($ageGroups) }} Groups</div>
        </div>
        <div class="chart-body chart-body-lg">
            <canvas id="ageGroupChart"></canvas>
        </div>
    </div>

    <!-- Section: Senior Prediction Analytics -->
    <div class="section-divider" style="animation-delay: 0.45s">
        <div class="divider-icon icon-violet">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
            </svg>
        </div>
        <span class="divider-text">Senior Citizen Prediction Analytics</span>
        <div class="divider-line"></div>
    </div>

    <!-- Quick Access to Full Analytics -->
    <div class="analytics-banner" style="animation-delay: 0.5s">
        <div class="banner-content">
            <div class="banner-text">
                <h3>Advanced Analytics Dashboard</h3>
                <p>Access detailed predictions, reports, and data visualizations</p>
            </div>
            <a href="{{ route('special-reports.senior-prediction') }}" class="banner-btn">
                <span>View Full Analytics</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>
    </div>

    <!-- Yearly Trend Chart -->
    <div class="chart-card full-width" style="animation-delay: 0.55s">
        <div class="chart-header header-gradient-violet">
            <div class="chart-title-wrap">
                <div class="chart-icon icon-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                </div>
                <div>
                    <h3 class="chart-title text-white">10-Year Prediction Trend</h3>
                    <p class="chart-subtitle text-white-muted">Residents who will turn 60 years old per year</p>
                </div>
            </div>
        </div>
        <div class="chart-body chart-body-lg">
            <canvas id="yearlyTrendChart"></canvas>
        </div>
    </div>

    <!-- Monthly and Purok Breakdown -->
    <div class="charts-row" style="animation-delay: 0.6s">
        <div class="chart-card">
            <div class="chart-header header-gradient-rose">
                <div class="chart-title-wrap">
                    <div class="chart-icon icon-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <h3 class="chart-title text-white">Monthly Breakdown {{ $currentYear + 1 }}</h3>
                        <p class="chart-subtitle text-white-muted">Distribution by birth month</p>
                    </div>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="seniorMonthlyChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header header-gradient-cyan">
                <div class="chart-title-wrap">
                    <div class="chart-icon icon-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 class="chart-title text-white">By Purok {{ $currentYear + 1 }}</h3>
                        <p class="chart-subtitle text-white-muted">Distribution by area</p>
                    </div>
                </div>
            </div>
            <div class="chart-body chart-body-donut">
                <canvas id="seniorPurokChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Color palette
    const colors = {
        blue: '#3b82f6',
        blueLight: 'rgba(59, 130, 246, 0.1)',
        violet: '#8b5cf6',
        violetLight: 'rgba(139, 92, 246, 0.1)',
        emerald: '#10b981',
        emeraldLight: 'rgba(16, 185, 129, 0.1)',
        amber: '#f59e0b',
        amberLight: 'rgba(245, 158, 11, 0.1)',
        rose: '#f43f5e',
        roseLight: 'rgba(244, 63, 94, 0.1)',
        cyan: '#06b6d4',
        gray: '#64748b'
    };
    
    const gradientColors = [
        '#3b82f6', '#8b5cf6', '#f43f5e', '#f59e0b', '#10b981',
        '#06b6d4', '#ec4899', '#84cc16', '#f97316', '#6366f1',
        '#14b8a6', '#eab308'
    ];

    const chartDefaults = {
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
                titleFont: { size: 13, weight: '600' },
                bodyFont: { size: 12 },
                padding: 12,
                cornerRadius: 8,
                displayColors: true
            }
        }
    };

    // Purok Distribution Chart
    const purokCtx = document.getElementById('purokChart').getContext('2d');
    const purokGradient = purokCtx.createLinearGradient(0, 0, 0, 300);
    purokGradient.addColorStop(0, 'rgba(59, 130, 246, 0.8)');
    purokGradient.addColorStop(1, 'rgba(59, 130, 246, 0.3)');

    new Chart(purokCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($purokCounts->keys()) !!},
            datasets: [{
                label: 'Number of Residents',
                data: {!! json_encode($purokCounts->values()) !!},
                backgroundColor: purokGradient,
                borderColor: colors.blue,
                borderWidth: 0,
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                    ticks: { font: { size: 11, weight: '500' }, color: colors.gray }
                },
                x: {
                    grid: { display: false },
                    ticks: { 
                        font: { size: 10, weight: '500' }, 
                        color: colors.gray,
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });

    // Gender Distribution Chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [{{ $maleCount }}, {{ $femaleCount }}],
                backgroundColor: [colors.blue, colors.rose],
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 8
            }]
        },
        options: {
            ...chartDefaults,
            cutout: '65%',
            plugins: {
                ...chartDefaults.plugins,
                legend: {
                    display: false
                }
            }
        }
    });

    // Civil Status Chart
    const civilStatusCtx = document.getElementById('civilStatusChart').getContext('2d');
    const civilStatusLabels = {!! json_encode($civilStatusCounts->keys()) !!};
    const civilStatusData = {!! json_encode($civilStatusCounts->values()) !!};
    
    new Chart(civilStatusCtx, {
        type: 'bar',
        data: {
            labels: civilStatusLabels,
            datasets: [{
                label: 'Number of Residents',
                data: civilStatusData,
                backgroundColor: gradientColors.slice(0, civilStatusLabels.length),
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            ...chartDefaults,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                    ticks: { font: { size: 11, weight: '500' }, color: colors.gray }
                },
                y: {
                    grid: { display: false },
                    ticks: { font: { size: 11, weight: '500' }, color: colors.gray }
                }
            }
        }
    });

    // Age Group Distribution Chart
    const ageGroupCtx = document.getElementById('ageGroupChart').getContext('2d');
    const ageLabels = {!! json_encode(array_keys($ageGroups)) !!};
    const ageData = {!! json_encode(array_values($ageGroups)) !!};
    
    new Chart(ageGroupCtx, {
        type: 'bar',
        data: {
            labels: ageLabels,
            datasets: [{
                label: 'Number of Residents',
                data: ageData,
                backgroundColor: gradientColors.slice(0, ageLabels.length),
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                    ticks: { font: { size: 11, weight: '500' }, color: colors.gray }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10, weight: '500' }, color: colors.gray }
                }
            }
        }
    });

    // Senior Citizen Prediction Charts
    
    // Yearly Trend Chart
    const yearlyCtx = document.getElementById('yearlyTrendChart').getContext('2d');
    const yearlyData = {!! json_encode($analytics) !!};
    
    const yearlyGradient = yearlyCtx.createLinearGradient(0, 0, 0, 300);
    yearlyGradient.addColorStop(0, 'rgba(139, 92, 246, 0.3)');
    yearlyGradient.addColorStop(1, 'rgba(139, 92, 246, 0.02)');
    
    new Chart(yearlyCtx, {
        type: 'line',
        data: {
            labels: yearlyData.map(d => d.year),
            datasets: [{
                label: 'Residents Turning 60',
                data: yearlyData.map(d => d.count),
                backgroundColor: yearlyGradient,
                borderColor: colors.violet,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 9,
                pointBackgroundColor: '#fff',
                pointBorderColor: colors.violet,
                pointBorderWidth: 3,
                pointHoverBackgroundColor: colors.violet,
                pointHoverBorderColor: '#fff'
            }]
        },
        options: {
            ...chartDefaults,
            interaction: { intersect: false, mode: 'index' },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                    ticks: { font: { size: 11, weight: '500' }, color: colors.gray }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11, weight: '600' }, color: colors.gray }
                }
            }
        }
    });

    // Senior Monthly Chart
    const seniorMonthlyCtx = document.getElementById('seniorMonthlyChart').getContext('2d');
    const monthlyData = {!! json_encode($monthlyData) !!};
    
    new Chart(seniorMonthlyCtx, {
        type: 'bar',
        data: {
            labels: monthlyData.map(d => d.month_name.substring(0, 3)),
            datasets: [{
                label: 'Residents',
                data: monthlyData.map(d => d.count),
                backgroundColor: gradientColors.slice(0, 12),
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                    ticks: { font: { size: 10 }, color: colors.gray, stepSize: 1 }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10, weight: '500' }, color: colors.gray }
                }
            }
        }
    });

    // Senior Purok Chart
    const seniorPurokCtx = document.getElementById('seniorPurokChart').getContext('2d');
    const seniorPurokData = {!! json_encode($seniorPurokData) !!};
    
    new Chart(seniorPurokCtx, {
        type: 'doughnut',
        data: {
            labels: seniorPurokData.map(d => d.purok_name),
            datasets: [{
                data: seniorPurokData.map(d => d.count),
                backgroundColor: gradientColors.slice(0, seniorPurokData.length),
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 8
            }]
        },
        options: {
            ...chartDefaults,
            cutout: '55%',
            plugins: {
                ...chartDefaults.plugins,
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        font: { size: 11, weight: '500' },
                        color: colors.gray,
                        padding: 10,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    ...chartDefaults.plugins.tooltip,
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return context.label + ': ' + value + ' (' + percentage + '%)';
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
    --gp-primary: #0f172a;
    --gp-primary-light: #1e293b;
    --gp-accent: #3b82f6;
    --gp-accent-light: #60a5fa;
    --gp-violet: #8b5cf6;
    --gp-violet-light: #a78bfa;
    --gp-emerald: #10b981;
    --gp-amber: #f59e0b;
    --gp-rose: #f43f5e;
    --gp-cyan: #06b6d4;
    --gp-gray-50: #f8fafc;
    --gp-gray-100: #f1f5f9;
    --gp-gray-200: #e2e8f0;
    --gp-gray-300: #cbd5e1;
    --gp-gray-400: #94a3b8;
    --gp-gray-500: #64748b;
    --gp-gray-600: #475569;
    --gp-gray-700: #334155;
    --gp-gray-800: #1e293b;
    --gp-gray-900: #0f172a;
    --gp-radius: 16px;
    --gp-radius-sm: 10px;
    --gp-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --gp-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
}

/* ===== Page Container ===== */
.graph-page {
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
    padding: 2.5rem 2rem;
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, var(--gp-primary) 0%, var(--gp-primary-light) 100%);
    border-radius: var(--gp-radius);
    overflow: hidden;
    animation: fadeInDown 0.6s ease-out;
}

.header-content { position: relative; z-index: 2; }

.header-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--gp-accent) 0%, var(--gp-violet) 100%);
    border-radius: 20px;
    margin-bottom: 1.25rem;
    color: white;
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
}

.page-title {
    font-size: 2.25rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.5rem;
    letter-spacing: -0.02em;
}

.page-subtitle {
    font-size: 1rem;
    color: var(--gp-gray-300);
    margin: 0;
}

.header-decoration { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }

.floating-shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
}

.shape-1 {
    width: 250px; height: 250px;
    background: var(--gp-accent);
    top: -80px; right: -40px;
    animation: float 8s ease-in-out infinite;
}

.shape-2 {
    width: 180px; height: 180px;
    background: var(--gp-violet);
    bottom: -40px; left: 10%;
    animation: float 6s ease-in-out infinite reverse;
}

.shape-3 {
    width: 120px; height: 120px;
    background: var(--gp-emerald);
    top: 20%; left: -20px;
    animation: float 7s ease-in-out infinite 1s;
}

/* ===== Quick Stats Bar ===== */
.quick-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 1.5rem;
    background: white;
    padding: 1.25rem 2rem;
    border-radius: var(--gp-radius-sm);
    border: 1px solid var(--gp-gray-200);
    margin-bottom: 2rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

.stat-item { display: flex; align-items: center; gap: 0.75rem; }

.stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px; height: 44px;
    border-radius: 10px;
}

.icon-blue { background: rgba(59, 130, 246, 0.1); color: var(--gp-accent); }
.icon-emerald { background: rgba(16, 185, 129, 0.1); color: var(--gp-emerald); }
.icon-rose { background: rgba(244, 63, 94, 0.1); color: var(--gp-rose); }
.icon-amber { background: rgba(245, 158, 11, 0.1); color: var(--gp-amber); }
.icon-violet { background: rgba(139, 92, 246, 0.1); color: var(--gp-violet); }

.stat-data { display: flex; flex-direction: column; }

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gp-gray-900);
    line-height: 1;
}

.stat-label {
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--gp-gray-500);
    margin-top: 0.15rem;
}

.stat-divider {
    width: 1px; height: 40px;
    background: var(--gp-gray-200);
}

/* ===== Section Divider ===== */
.section-divider {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 2.5rem 0 1.5rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

.divider-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px; height: 40px;
    background: var(--gp-gray-100);
    border-radius: 10px;
    color: var(--gp-gray-500);
}

.divider-icon.icon-violet {
    background: rgba(139, 92, 246, 0.1);
    color: var(--gp-violet);
}

.divider-text {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--gp-gray-700);
    white-space: nowrap;
}

.divider-line {
    flex: 1;
    height: 2px;
    background: linear-gradient(90deg, var(--gp-gray-200) 0%, transparent 100%);
}

/* ===== Analytics Banner ===== */
.analytics-banner {
    background: linear-gradient(135deg, var(--gp-violet) 0%, var(--gp-accent) 100%);
    border-radius: var(--gp-radius-sm);
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

.banner-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.banner-text h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.25rem;
}

.banner-text p {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
}

.banner-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: white;
    color: var(--gp-violet);
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.banner-btn:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

/* ===== Chart Cards ===== */
.charts-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 992px) {
    .charts-row { grid-template-columns: 1fr; }
}

.chart-card {
    background: white;
    border-radius: var(--gp-radius);
    border: 1px solid var(--gp-gray-200);
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out backwards;
    transition: all 0.3s ease;
}

.chart-card:hover {
    box-shadow: var(--gp-shadow-lg);
}

.chart-card.full-width {
    margin-bottom: 1.5rem;
}

.chart-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--gp-gray-100);
}

.header-gradient-violet {
    background: linear-gradient(135deg, var(--gp-violet) 0%, #7c3aed 100%);
    border-bottom: none;
}

.header-gradient-rose {
    background: linear-gradient(135deg, var(--gp-rose) 0%, #e11d48 100%);
    border-bottom: none;
}

.header-gradient-cyan {
    background: linear-gradient(135deg, var(--gp-cyan) 0%, #0891b2 100%);
    border-bottom: none;
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
    width: 40px; height: 40px;
    border-radius: 10px;
    color: white;
}

.gradient-blue { background: linear-gradient(135deg, var(--gp-accent) 0%, #2563eb 100%); }
.gradient-emerald { background: linear-gradient(135deg, var(--gp-emerald) 0%, #059669 100%); }
.gradient-violet { background: linear-gradient(135deg, var(--gp-violet) 0%, #7c3aed 100%); }
.gradient-amber { background: linear-gradient(135deg, var(--gp-amber) 0%, #d97706 100%); }

.icon-white {
    background: rgba(255, 255, 255, 0.2);
}

.chart-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--gp-gray-800);
    margin: 0;
}

.chart-subtitle {
    font-size: 0.8rem;
    color: var(--gp-gray-500);
    margin: 0;
}

.text-white { color: white !important; }
.text-white-muted { color: rgba(255, 255, 255, 0.75) !important; }

.chart-badge {
    display: inline-flex;
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 20px;
}

.badge-blue { background: rgba(59, 130, 246, 0.1); color: var(--gp-accent); }
.badge-amber { background: rgba(245, 158, 11, 0.1); color: var(--gp-amber); }

.chart-body {
    padding: 1.5rem;
    height: 280px;
}

.chart-body-lg {
    height: 320px;
}

.chart-body-donut {
    display: flex;
    align-items: center;
    justify-content: center;
}

.chart-footer {
    display: flex;
    justify-content: center;
    gap: 2rem;
    padding: 1rem 1.5rem;
    background: var(--gp-gray-50);
    border-top: 1px solid var(--gp-gray-100);
}

.footer-stat {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--gp-gray-600);
}

.footer-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
}

.dot-blue { background: var(--gp-accent); }
.dot-rose { background: var(--gp-rose); }

/* ===== Animations ===== */
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

/* ===== Dark Mode Support ===== */
.dark .graph-page {
    --gp-gray-50: #1e293b;
    --gp-gray-100: #334155;
    --gp-gray-200: #475569;
    --gp-gray-300: #64748b;
    --gp-gray-400: #94a3b8;
    --gp-gray-500: #cbd5e1;
    --gp-gray-600: #e2e8f0;
    --gp-gray-700: #f1f5f9;
    --gp-gray-800: #f8fafc;
    --gp-gray-900: #ffffff;
}

.dark .quick-stats,
.dark .chart-card {
    background: var(--gp-primary-light);
    border-color: var(--gp-gray-200);
}

.dark .chart-footer {
    background: rgba(0, 0, 0, 0.2);
}

/* ===== Responsive Adjustments ===== */
@media (max-width: 768px) {
    .graph-page { padding: 1rem; }
    
    .page-header { padding: 2rem 1.5rem; }
    
    .page-title { font-size: 1.75rem; }
    
    .quick-stats {
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
    }
    
    .stat-divider { width: 100%; height: 1px; }
    
    .chart-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .chart-body { padding: 1rem; height: 250px; }
    .chart-body-lg { height: 280px; }
    
    .banner-content {
        flex-direction: column;
        text-align: center;
    }
    
    .section-divider { flex-wrap: wrap; }
    
    .divider-text { font-size: 1rem; }
}
</style>
@endsection
