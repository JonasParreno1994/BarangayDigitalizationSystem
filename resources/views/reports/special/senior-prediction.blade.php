@extends('layouts.adminLayout.index')

@section('content')
<div class="senior-prediction-page">
    <!-- Animated Background -->
    <div class="page-bg"></div>
    
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <h1 class="page-title">Senior Citizen Prediction</h1>
            <p class="page-subtitle">Forecast and plan for future senior citizens based on resident demographics</p>
        </div>
        <div class="header-decoration">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
        </div>
    </div>

    <!-- Stats Dashboard -->
    @php
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $birthYearNext = $nextYear - 60;
        
        $nextYearCount = \App\Models\ResidentModel::where('is_senior_citizen', false)
            ->whereYear('birth_date', $birthYearNext)
            ->count();
            
        $birthYearCurrent = $currentYear - 60;
        $currentYearCount = \App\Models\ResidentModel::where('is_senior_citizen', false)
            ->whereYear('birth_date', $birthYearCurrent)
            ->count();
            
        $totalFutureCount = \App\Models\ResidentModel::where('is_senior_citizen', false)
            ->whereBetween('birth_date', [
                date('Y-m-d', strtotime(($currentYear - 60) . '-01-01')),
                date('Y-m-d', strtotime(($currentYear - 55) . '-12-31'))
            ])
            ->count();
            
        $totalSeniors = \App\Models\ResidentModel::where('is_senior_citizen', true)->count();
    @endphp

    <div class="stats-grid">
        <!-- Current Year Card -->
        <div class="stat-card stat-card-amber" style="animation-delay: 0.1s">
            <div class="stat-card-inner">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                        <circle cx="12" cy="15" r="2"></circle>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Turning 60 This Year</span>
                    <span class="stat-value">{{ $currentYearCount }}</span>
                    <span class="stat-year">{{ $currentYear }}</span>
                </div>
                <div class="stat-ring"></div>
            </div>
        </div>

        <!-- Next Year Card -->
        <div class="stat-card stat-card-emerald" style="animation-delay: 0.2s">
            <div class="stat-card-inner">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                        <path d="M12 14l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Turning 60 Next Year</span>
                    <span class="stat-value">{{ $nextYearCount }}</span>
                    <span class="stat-year">{{ $nextYear }}</span>
                </div>
                <div class="stat-ring"></div>
            </div>
        </div>

        <!-- 5-Year Projection Card -->
        <div class="stat-card stat-card-violet" style="animation-delay: 0.3s">
            <div class="stat-card-inner">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="20" x2="12" y2="10"></line>
                        <line x1="18" y1="20" x2="18" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="16"></line>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-label">5-Year Projection</span>
                    <span class="stat-value">{{ $totalFutureCount }}</span>
                    <span class="stat-year">{{ $currentYear }}-{{ $currentYear + 5 }}</span>
                </div>
                <div class="stat-ring"></div>
            </div>
        </div>

        <!-- Current Seniors Card -->
        <div class="stat-card stat-card-rose" style="animation-delay: 0.4s">
            <div class="stat-card-inner">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Current Senior Citizens</span>
                    <span class="stat-value">{{ $totalSeniors }}</span>
                    <span class="stat-year">Registered</span>
                </div>
                <div class="stat-ring"></div>
            </div>
        </div>
    </div>

    <!-- Analytics Quick Access -->
    <div class="analytics-banner" style="animation-delay: 0.5s">
        <div class="analytics-content">
            <div class="analytics-text">
                <h3>Data Visualization & Analytics</h3>
                <p>Explore charts, trends, and detailed demographic breakdowns</p>
            </div>
            <a href="{{ route('special-reports.senior-prediction-analytics') }}" class="analytics-btn" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                <span>View Analytics Dashboard</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="arrow-icon">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>
        <div class="analytics-visual">
            <div class="mini-chart">
                <div class="bar bar-1"></div>
                <div class="bar bar-2"></div>
                <div class="bar bar-3"></div>
                <div class="bar bar-4"></div>
                <div class="bar bar-5"></div>
            </div>
        </div>
    </div>

    <!-- Report Generation Section -->
    <div class="report-section" style="animation-delay: 0.6s">
        <div class="section-header">
            <div class="section-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <div class="section-title-wrap">
                <h2 class="section-title">Generate Prediction Report</h2>
                <p class="section-desc">Filter by year, purok, and month to generate detailed forecasts</p>
            </div>
        </div>

        <form id="predictionForm" action="{{ route('special-reports.generate-senior-prediction') }}" method="POST" target="_blank" class="report-form">
            @csrf

            <div class="form-grid">
                <!-- Prediction Year -->
                <div class="form-group">
                    <label for="prediction_year" class="form-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Prediction Year
                    </label>
                    <div class="select-wrapper">
                        <select class="form-select" id="prediction_year" name="prediction_year" required>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ $year == $nextYear ? 'selected' : '' }}>
                                    {{ $year }}
                                    @php
                                        $birthYear = $year - 60;
                                        $count = \App\Models\ResidentModel::where('is_senior_citizen', false)
                                            ->whereYear('birth_date', $birthYear)
                                            ->count();
                                    @endphp
                                    ({{ $count }} residents)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <span class="form-hint">Residents turning 60 in selected year</span>
                </div>

                <!-- Purok Filter -->
                <div class="form-group">
                    <label for="purok_id" class="form-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        Filter by Purok
                    </label>
                    <div class="select-wrapper">
                        <select class="form-select" id="purok_id" name="purok_id">
                            <option value="">All Puroks</option>
                            @foreach($puroks as $purok)
                                <option value="{{ $purok->id }}">{{ $purok->purok_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="form-hint">Optional: Select specific purok</span>
                </div>

                <!-- Month Filter -->
                <div class="form-group">
                    <label for="month" class="form-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Filter by Month
                    </label>
                    <div class="select-wrapper">
                        <select class="form-select" id="month" name="month">
                            <option value="">All Months</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <span class="form-hint">Optional: Filter by birth month</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button type="submit" class="btn-primary-action">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                    <span>Generate Report</span>
                </button>
                <button type="button" onclick="printReport()" class="btn-secondary-action">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        <rect x="6" y="14" width="12" height="8"></rect>
                    </svg>
                    <span>Print Report</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Info Section -->
    <div class="info-section" style="animation-delay: 0.7s">
        <div class="info-header">
            <div class="info-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
            </div>
            <h3>How This Prediction Tool Works</h3>
        </div>
        <div class="info-content">
            <p class="info-intro">
                This tool analyzes resident birth dates to identify those who will turn 60 years old in selected future years, enabling proactive planning for senior citizen services.
            </p>
            <div class="benefits-grid">
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48l2.83-2.83"></path>
                        </svg>
                    </div>
                    <span>Plan senior benefits & services in advance</span>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <span>Prepare budget allocations accurately</span>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <span>Coordinate ID processing schedules</span>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <span>Conduct outreach programs proactively</span>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                    </div>
                    <span>Track demographic trends for policy planning</span>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <span>Improve resource allocation efficiency</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printReport() {
        const predictionYear = document.getElementById('prediction_year').value;
        const purokId = document.getElementById('purok_id').value;
        const month = document.getElementById('month').value;
        
        let params = new URLSearchParams();
        params.append('prediction_year', predictionYear);
        if (purokId) params.append('purok_id', purokId);
        if (month) params.append('month', month);
        
        window.open('{{ route('special-reports.print-senior-prediction') }}?' + params.toString(), '_blank');
    }
</script>

<style>
/* ===== CSS Variables ===== */
:root {
    --sp-primary: #0f172a;
    --sp-primary-light: #1e293b;
    --sp-accent: #3b82f6;
    --sp-accent-light: #60a5fa;
    --sp-amber: #f59e0b;
    --sp-amber-light: #fbbf24;
    --sp-emerald: #10b981;
    --sp-emerald-light: #34d399;
    --sp-violet: #8b5cf6;
    --sp-violet-light: #a78bfa;
    --sp-rose: #f43f5e;
    --sp-rose-light: #fb7185;
    --sp-gray-50: #f8fafc;
    --sp-gray-100: #f1f5f9;
    --sp-gray-200: #e2e8f0;
    --sp-gray-300: #cbd5e1;
    --sp-gray-400: #94a3b8;
    --sp-gray-500: #64748b;
    --sp-gray-600: #475569;
    --sp-gray-700: #334155;
    --sp-gray-800: #1e293b;
    --sp-gray-900: #0f172a;
    --sp-radius: 16px;
    --sp-radius-sm: 10px;
    --sp-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --sp-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --sp-shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

/* ===== Page Container ===== */
.senior-prediction-page {
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
    margin-bottom: 3rem;
    background: linear-gradient(135deg, var(--sp-primary) 0%, var(--sp-primary-light) 100%);
    border-radius: var(--sp-radius);
    overflow: hidden;
    animation: fadeInDown 0.6s ease-out;
}

.header-content {
    position: relative;
    z-index: 2;
}

.header-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--sp-accent) 0%, var(--sp-violet) 100%);
    border-radius: 20px;
    margin-bottom: 1.5rem;
    color: white;
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.75rem;
    letter-spacing: -0.02em;
}

.page-subtitle {
    font-size: 1.1rem;
    color: var(--sp-gray-300);
    margin: 0;
    max-width: 500px;
    margin: 0 auto;
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
    background: var(--sp-accent);
    top: -100px;
    right: -50px;
    animation: float 8s ease-in-out infinite;
}

.shape-2 {
    width: 200px;
    height: 200px;
    background: var(--sp-violet);
    bottom: -50px;
    left: 10%;
    animation: float 6s ease-in-out infinite reverse;
}

.shape-3 {
    width: 150px;
    height: 150px;
    background: var(--sp-emerald);
    top: 20%;
    left: -30px;
    animation: float 7s ease-in-out infinite 1s;
}

/* ===== Stats Grid ===== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

.stat-card {
    position: relative;
    border-radius: var(--sp-radius);
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out backwards;
}

.stat-card-inner {
    position: relative;
    padding: 1.75rem;
    background: white;
    border-radius: var(--sp-radius);
    border: 1px solid var(--sp-gray-200);
    transition: all 0.3s ease;
    overflow: hidden;
}

.stat-card:hover .stat-card-inner {
    transform: translateY(-4px);
    box-shadow: var(--sp-shadow-xl);
}

.stat-card-amber .stat-card-inner { border-top: 4px solid var(--sp-amber); }
.stat-card-emerald .stat-card-inner { border-top: 4px solid var(--sp-emerald); }
.stat-card-violet .stat-card-inner { border-top: 4px solid var(--sp-violet); }
.stat-card-rose .stat-card-inner { border-top: 4px solid var(--sp-rose); }

.stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    border-radius: 14px;
    margin-bottom: 1rem;
}

.stat-card-amber .stat-icon {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(251, 191, 36, 0.15) 100%);
    color: var(--sp-amber);
}

.stat-card-emerald .stat-icon {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(52, 211, 153, 0.15) 100%);
    color: var(--sp-emerald);
}

.stat-card-violet .stat-icon {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(167, 139, 250, 0.15) 100%);
    color: var(--sp-violet);
}

.stat-card-rose .stat-icon {
    background: linear-gradient(135deg, rgba(244, 63, 94, 0.15) 0%, rgba(251, 113, 133, 0.15) 100%);
    color: var(--sp-rose);
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--sp-gray-500);
    margin-bottom: 0.5rem;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--sp-gray-900);
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-year {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--sp-gray-400);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.stat-ring {
    position: absolute;
    top: -50px;
    right: -50px;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    opacity: 0.05;
}

.stat-card-amber .stat-ring { background: var(--sp-amber); }
.stat-card-emerald .stat-ring { background: var(--sp-emerald); }
.stat-card-violet .stat-ring { background: var(--sp-violet); }
.stat-card-rose .stat-ring { background: var(--sp-rose); }

/* ===== Analytics Banner ===== */
.analytics-banner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, var(--sp-accent) 0%, var(--sp-violet) 100%);
    border-radius: var(--sp-radius);
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    overflow: hidden;
    position: relative;
    animation: fadeInUp 0.6s ease-out backwards;
}

.analytics-content {
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
    z-index: 2;
}

.analytics-text h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.25rem;
}

.analytics-text p {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
}

.analytics-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: white;
    color: var(--sp-primary);
    font-weight: 600;
    padding: 0.875rem 1.5rem;
    border-radius: var(--sp-radius-sm);
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.analytics-btn:hover {
    transform: translateX(5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.analytics-btn .arrow-icon {
    transition: transform 0.3s ease;
}

.analytics-btn:hover .arrow-icon {
    transform: translateX(4px);
}

.analytics-visual {
    position: relative;
    z-index: 1;
}

.mini-chart {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    height: 60px;
}

.mini-chart .bar {
    width: 12px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 4px;
    animation: barGrow 1.5s ease-out forwards;
}

.bar-1 { height: 40%; animation-delay: 0.1s; }
.bar-2 { height: 70%; animation-delay: 0.2s; }
.bar-3 { height: 50%; animation-delay: 0.3s; }
.bar-4 { height: 90%; animation-delay: 0.4s; }
.bar-5 { height: 60%; animation-delay: 0.5s; }

/* ===== Report Section ===== */
.report-section {
    background: white;
    border-radius: var(--sp-radius);
    border: 1px solid var(--sp-gray-200);
    overflow: hidden;
    margin-bottom: 2rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 2rem;
    background: var(--sp-gray-50);
    border-bottom: 1px solid var(--sp-gray-200);
}

.section-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--sp-accent) 0%, var(--sp-violet) 100%);
    border-radius: 12px;
    color: white;
}

.section-title-wrap {
    flex: 1;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--sp-gray-900);
    margin: 0 0 0.25rem;
}

.section-desc {
    font-size: 0.9rem;
    color: var(--sp-gray-500);
    margin: 0;
}

.report-form {
    padding: 2rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 992px) {
    .form-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--sp-gray-700);
    margin-bottom: 0.5rem;
}

.form-label svg {
    color: var(--sp-gray-400);
}

.select-wrapper {
    position: relative;
}

.form-select {
    width: 100%;
    padding: 0.875rem 1rem;
    padding-right: 2.5rem;
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--sp-gray-800);
    background: var(--sp-gray-50);
    border: 2px solid var(--sp-gray-200);
    border-radius: var(--sp-radius-sm);
    appearance: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.form-select:hover {
    border-color: var(--sp-gray-300);
}

.form-select:focus {
    outline: none;
    border-color: var(--sp-accent);
    background: white;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.select-wrapper::after {
    content: '';
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 6px solid var(--sp-gray-400);
    pointer-events: none;
}

.form-hint {
    font-size: 0.8rem;
    color: var(--sp-gray-400);
    margin-top: 0.5rem;
}

/* ===== Action Buttons ===== */
.action-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-primary-action,
.btn-secondary-action {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: var(--sp-radius-sm);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary-action {
    background: linear-gradient(135deg, var(--sp-accent) 0%, var(--sp-violet) 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
}

.btn-primary-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
}

.btn-secondary-action {
    background: white;
    color: var(--sp-emerald);
    border: 2px solid var(--sp-emerald);
}

.btn-secondary-action:hover {
    background: var(--sp-emerald);
    color: white;
    transform: translateY(-2px);
}

/* ===== Info Section ===== */
.info-section {
    background: white;
    border-radius: var(--sp-radius);
    border: 1px solid var(--sp-gray-200);
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out backwards;
}

.info-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 2rem;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
    border-bottom: 1px solid var(--sp-gray-200);
}

.info-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--sp-accent);
    border-radius: 10px;
    color: white;
}

.info-header h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--sp-gray-800);
    margin: 0;
}

.info-content {
    padding: 1.5rem 2rem;
}

.info-intro {
    font-size: 0.95rem;
    color: var(--sp-gray-600);
    line-height: 1.6;
    margin: 0 0 1.5rem;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

@media (max-width: 992px) {
    .benefits-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .benefits-grid {
        grid-template-columns: 1fr;
    }
}

.benefit-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--sp-gray-50);
    border-radius: var(--sp-radius-sm);
    transition: all 0.2s ease;
}

.benefit-item:hover {
    background: var(--sp-gray-100);
    transform: translateX(4px);
}

.benefit-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: white;
    border-radius: 8px;
    color: var(--sp-accent);
    flex-shrink: 0;
    box-shadow: var(--sp-shadow);
}

.benefit-item span {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--sp-gray-700);
    line-height: 1.4;
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

@keyframes barGrow {
    from {
        transform: scaleY(0);
        opacity: 0;
    }
    to {
        transform: scaleY(1);
        opacity: 1;
    }
}

/* ===== Dark Mode Support ===== */
.dark .senior-prediction-page {
    --sp-gray-50: #1e293b;
    --sp-gray-100: #334155;
    --sp-gray-200: #475569;
    --sp-gray-300: #64748b;
    --sp-gray-400: #94a3b8;
    --sp-gray-500: #cbd5e1;
    --sp-gray-600: #e2e8f0;
    --sp-gray-700: #f1f5f9;
    --sp-gray-800: #f8fafc;
    --sp-gray-900: #ffffff;
}

.dark .stat-card-inner,
.dark .report-section,
.dark .info-section {
    background: var(--sp-primary-light);
    border-color: var(--sp-gray-200);
}

.dark .section-header,
.dark .info-header {
    background: rgba(0, 0, 0, 0.2);
}

.dark .form-select {
    background: var(--sp-primary);
    color: white;
}

.dark .benefit-item {
    background: rgba(0, 0, 0, 0.2);
}

.dark .benefit-icon {
    background: var(--sp-primary);
}

/* ===== Responsive Adjustments ===== */
@media (max-width: 768px) {
    .senior-prediction-page {
        padding: 1rem;
    }
    
    .page-header {
        padding: 2rem 1.5rem;
    }
    
    .page-title {
        font-size: 1.75rem;
    }
    
    .analytics-banner {
        flex-direction: column;
        text-align: center;
        padding: 1.5rem;
    }
    
    .analytics-content {
        flex-direction: column;
    }
    
    .analytics-visual {
        display: none;
    }
    
    .section-header {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    
    .report-form {
        padding: 1.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-primary-action,
    .btn-secondary-action {
        width: 100%;
        justify-content: center;
    }
    
    .info-header {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    
    .info-content {
        padding: 1.25rem;
    }
}
</style>
@endsection
