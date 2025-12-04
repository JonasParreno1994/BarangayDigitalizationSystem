@extends('layouts.adminLayout.index')

@section('content')
<div class="results-page">
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
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <h1 class="page-title">Prediction Report</h1>
            <p class="page-subtitle">Residents who will turn 60 years old in <strong>{{ $predictionYear }}</strong></p>
        </div>
        <div class="header-decoration">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
        </div>
    </div>

    <!-- Filter Summary -->
    <div class="filter-summary" style="animation-delay: 0.1s">
        <div class="filter-item">
            <div class="filter-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="filter-content">
                <span class="filter-label">Prediction Year</span>
                <span class="filter-value">{{ $predictionYear }}</span>
            </div>
        </div>
        <div class="filter-divider"></div>
        <div class="filter-item">
            <div class="filter-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="filter-content">
                <span class="filter-label">Month</span>
                <span class="filter-value">{{ $month ? date('F', mktime(0, 0, 0, $month, 1)) : 'All Months' }}</span>
            </div>
        </div>
        <div class="filter-divider"></div>
        <div class="filter-item">
            <div class="filter-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
            <div class="filter-content">
                <span class="filter-label">Purok</span>
                <span class="filter-value">{{ $purok ? $purok->purok_name : 'All Puroks' }}</span>
            </div>
        </div>
        <div class="filter-divider"></div>
        <div class="filter-item filter-total">
            <div class="filter-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="filter-content">
                <span class="filter-label">Total Found</span>
                <span class="filter-value highlight">{{ $residents->count() }} residents</span>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid" style="animation-delay: 0.2s">
        <div class="stat-card stat-card-blue">
            <div class="stat-card-inner">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $residents->where('sex', 'Male')->count() }}</span>
                    <span class="stat-label">Male</span>
                </div>
                <div class="stat-percentage">
                    {{ $residents->count() > 0 ? round(($residents->where('sex', 'Male')->count() / $residents->count()) * 100) : 0 }}%
                </div>
            </div>
        </div>

        <div class="stat-card stat-card-rose">
            <div class="stat-card-inner">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $residents->where('sex', 'Female')->count() }}</span>
                    <span class="stat-label">Female</span>
                </div>
                <div class="stat-percentage">
                    {{ $residents->count() > 0 ? round(($residents->where('sex', 'Female')->count() / $residents->count()) * 100) : 0 }}%
                </div>
            </div>
        </div>

        <div class="stat-card stat-card-emerald">
            <div class="stat-card-inner">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $residents->whereNotNull('purok_id')->count() }}</span>
                    <span class="stat-label">With Purok</span>
                </div>
                <div class="stat-percentage">
                    {{ $residents->count() > 0 ? round(($residents->whereNotNull('purok_id')->count() / $residents->count()) * 100) : 0 }}%
                </div>
            </div>
        </div>

        <div class="stat-card stat-card-amber">
            <div class="stat-card-inner">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $residents->whereNotNull('contact_number')->count() }}</span>
                    <span class="stat-label">With Contact</span>
                </div>
                <div class="stat-percentage">
                    {{ $residents->count() > 0 ? round(($residents->whereNotNull('contact_number')->count() / $residents->count()) * 100) : 0 }}%
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="table-section" style="animation-delay: 0.3s">
        <div class="section-header">
            <div class="section-title-wrap">
                <div class="section-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="section-title">Resident List</h2>
                    <p class="section-desc">Future senior citizens for year {{ $predictionYear }}</p>
                </div>
            </div>
            <div class="table-actions no-print">
                <button onclick="exportToExcel()" class="action-btn-sm btn-excel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>Export Excel</span>
                </button>
            </div>
        </div>

        <div class="table-wrapper">
            @if($residents->count() > 0)
            <table class="data-table" id="predictionTable">
                <thead>
                    <tr>
                        <th class="th-num">#</th>
                        <th>Full Name</th>
                        <th>Birth Date</th>
                        <th class="th-center">Age</th>
                        <th class="th-center">Sex</th>
                        <th>Purok</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Civil Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($residents as $index => $resident)
                    <tr>
                        <td class="td-num">{{ $index + 1 }}</td>
                        <td>
                            <div class="resident-name">
                                <div class="avatar {{ $resident->sex == 'Male' ? 'avatar-male' : 'avatar-female' }}">
                                    {{ strtoupper(substr($resident->first_name, 0, 1)) }}{{ strtoupper(substr($resident->last_name, 0, 1)) }}
                                </div>
                                <div class="name-wrap">
                                    <span class="name-primary">{{ $resident->full_name }}</span>
                                    <span class="name-secondary">ID: {{ $resident->id }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="date-cell">
                                <span class="date-main">{{ $resident->birth_date->format('M d, Y') }}</span>
                                <span class="date-sub">Born {{ $resident->birth_date->format('Y') }}</span>
                            </div>
                        </td>
                        <td class="td-center">
                            <span class="age-badge">{{ $resident->age }}</span>
                        </td>
                        <td class="td-center">
                            <span class="sex-badge {{ $resident->sex == 'Male' ? 'badge-male' : 'badge-female' }}">
                                {{ $resident->sex }}
                            </span>
                        </td>
                        <td>
                            @if($resident->purok)
                                <span class="purok-name">{{ $resident->purok->purok_name }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="address-cell">{{ $resident->address ?? '—' }}</span>
                        </td>
                        <td>
                            @if($resident->contact_number)
                                <span class="contact-cell">{{ $resident->contact_number }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge">{{ $resident->civil_status ?? '—' }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                </div>
                <h3>No Residents Found</h3>
                <p>No residents match the selected criteria for year {{ $predictionYear }}</p>
                <a href="{{ route('special-reports.senior-prediction') }}" class="btn-back-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Adjust Filters
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Footer -->
    <div class="action-footer no-print" style="animation-delay: 0.4s">
        <a href="{{ route('special-reports.senior-prediction') }}" class="action-btn btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Back to Prediction</span>
        </a>
        <button onclick="printReport()" class="action-btn btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                <rect x="6" y="14" width="12" height="8"></rect>
            </svg>
            <span>Print Official Report</span>
        </button>
        <button onclick="exportToExcel()" class="action-btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            <span>Export to Excel</span>
        </button>
    </div>
</div>

<script>
    function printReport() {
        let params = new URLSearchParams();
        params.append('prediction_year', '{{ $predictionYear }}');
        @if($month)
        params.append('month', '{{ $month }}');
        @endif
        @if($purok)
        params.append('purok_id', '{{ $purok->id }}');
        @endif
        
        window.open('{{ route('special-reports.print-senior-prediction') }}?' + params.toString(), '_blank');
    }

    function exportToExcel() {
        const table = document.getElementById('predictionTable');
        if (!table) {
            alert('No data to export');
            return;
        }
        const wb = XLSX.utils.table_to_book(table, {sheet: "Predictions"});
        XLSX.writeFile(wb, 'senior_citizen_predictions_{{ $predictionYear }}.xlsx');
    }
</script>

<!-- SheetJS for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<style>
/* ===== CSS Variables ===== */
:root {
    --rp-primary: #0f172a;
    --rp-primary-light: #1e293b;
    --rp-accent: #3b82f6;
    --rp-accent-light: #60a5fa;
    --rp-violet: #8b5cf6;
    --rp-emerald: #10b981;
    --rp-amber: #f59e0b;
    --rp-rose: #f43f5e;
    --rp-gray-50: #f8fafc;
    --rp-gray-100: #f1f5f9;
    --rp-gray-200: #e2e8f0;
    --rp-gray-300: #cbd5e1;
    --rp-gray-400: #94a3b8;
    --rp-gray-500: #64748b;
    --rp-gray-600: #475569;
    --rp-gray-700: #334155;
    --rp-gray-800: #1e293b;
    --rp-gray-900: #0f172a;
    --rp-radius: 16px;
    --rp-radius-sm: 10px;
    --rp-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --rp-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
}

/* ===== Page Container ===== */
.results-page {
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
    background: linear-gradient(135deg, var(--rp-primary) 0%, var(--rp-primary-light) 100%);
    border-radius: var(--rp-radius);
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
    color: var(--rp-gray-300);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 1.25rem;
    transition: color 0.2s ease;
}

.back-link:hover {
    color: white;
}

.header-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 72px;
    height: 72px;
    background: linear-gradient(135deg, var(--rp-accent) 0%, var(--rp-violet) 100%);
    border-radius: 18px;
    margin-bottom: 1.25rem;
    color: white;
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.5rem;
    letter-spacing: -0.02em;
}

.page-subtitle {
    font-size: 1rem;
    color: var(--rp-gray-300);
    margin: 0;
}

.page-subtitle strong {
    color: var(--rp-accent-light);
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
    width: 250px;
    height: 250px;
    background: var(--rp-accent);
    top: -80px;
    right: -40px;
    animation: float 8s ease-in-out infinite;
}

.shape-2 {
    width: 180px;
    height: 180px;
    background: var(--rp-violet);
    bottom: -40px;
    left: 10%;
    animation: float 6s ease-in-out infinite reverse;
}

.shape-3 {
    width: 120px;
    height: 120px;
    background: var(--rp-emerald);
    top: 20%;
    left: -20px;
    animation: float 7s ease-in-out infinite 1s;
}

/* ===== Filter Summary ===== */
.filter-summary {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 1rem;
    background: white;
    padding: 1.25rem 2rem;
    border-radius: var(--rp-radius-sm);
    border: 1px solid var(--rp-gray-200);
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

.filter-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.filter-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: var(--rp-gray-100);
    border-radius: 8px;
    color: var(--rp-gray-500);
}

.filter-total .filter-icon {
    background: rgba(59, 130, 246, 0.1);
    color: var(--rp-accent);
}

.filter-content {
    display: flex;
    flex-direction: column;
}

.filter-label {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--rp-gray-400);
}

.filter-value {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--rp-gray-800);
}

.filter-value.highlight {
    color: var(--rp-accent);
}

.filter-divider {
    width: 1px;
    height: 36px;
    background: var(--rp-gray-200);
}

/* ===== Stats Grid ===== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

@media (max-width: 1200px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

.stat-card {
    position: relative;
    border-radius: var(--rp-radius-sm);
    overflow: hidden;
}

.stat-card-inner {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: white;
    border-radius: var(--rp-radius-sm);
    border: 1px solid var(--rp-gray-200);
    transition: all 0.3s ease;
}

.stat-card:hover .stat-card-inner {
    transform: translateY(-2px);
    box-shadow: var(--rp-shadow-lg);
}

.stat-card-blue .stat-card-inner { border-left: 4px solid var(--rp-accent); }
.stat-card-rose .stat-card-inner { border-left: 4px solid var(--rp-rose); }
.stat-card-emerald .stat-card-inner { border-left: 4px solid var(--rp-emerald); }
.stat-card-amber .stat-card-inner { border-left: 4px solid var(--rp-amber); }

.stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    border-radius: 12px;
    flex-shrink: 0;
}

.stat-card-blue .stat-icon { background: rgba(59, 130, 246, 0.1); color: var(--rp-accent); }
.stat-card-rose .stat-icon { background: rgba(244, 63, 94, 0.1); color: var(--rp-rose); }
.stat-card-emerald .stat-icon { background: rgba(16, 185, 129, 0.1); color: var(--rp-emerald); }
.stat-card-amber .stat-icon { background: rgba(245, 158, 11, 0.1); color: var(--rp-amber); }

.stat-content {
    display: flex;
    flex-direction: column;
    flex: 1;
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--rp-gray-900);
    line-height: 1;
}

.stat-label {
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--rp-gray-500);
    margin-top: 0.25rem;
}

.stat-percentage {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--rp-gray-400);
    padding: 0.25rem 0.5rem;
    background: var(--rp-gray-100);
    border-radius: 6px;
}

/* ===== Table Section ===== */
.table-section {
    background: white;
    border-radius: var(--rp-radius);
    border: 1px solid var(--rp-gray-200);
    overflow: hidden;
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    background: var(--rp-gray-50);
    border-bottom: 1px solid var(--rp-gray-200);
}

.section-title-wrap {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.section-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, var(--rp-accent) 0%, var(--rp-violet) 100%);
    border-radius: 11px;
    color: white;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--rp-gray-800);
    margin: 0;
}

.section-desc {
    font-size: 0.8rem;
    color: var(--rp-gray-500);
    margin: 0;
}

.table-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn-sm {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    font-size: 0.8rem;
    font-weight: 600;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-excel {
    background: rgba(16, 185, 129, 0.1);
    color: var(--rp-emerald);
}

.btn-excel:hover {
    background: var(--rp-emerald);
    color: white;
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
    border-bottom: 1px solid var(--rp-gray-100);
}

.data-table th {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--rp-gray-500);
    background: var(--rp-gray-50);
    position: sticky;
    top: 0;
}

.data-table td {
    font-size: 0.875rem;
    color: var(--rp-gray-700);
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background: rgba(59, 130, 246, 0.03);
}

.th-num { width: 50px; text-align: center; }
.th-center { text-align: center; }
.td-num { text-align: center; color: var(--rp-gray-400); font-weight: 600; }
.td-center { text-align: center; }

/* Resident Name Cell */
.resident-name {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.avatar {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 700;
    color: white;
    flex-shrink: 0;
}

.avatar-male { background: linear-gradient(135deg, var(--rp-accent) 0%, #1d4ed8 100%); }
.avatar-female { background: linear-gradient(135deg, var(--rp-rose) 0%, #be123c 100%); }

.name-wrap {
    display: flex;
    flex-direction: column;
}

.name-primary {
    font-weight: 600;
    color: var(--rp-gray-800);
}

.name-secondary {
    font-size: 0.7rem;
    color: var(--rp-gray-400);
}

/* Date Cell */
.date-cell {
    display: flex;
    flex-direction: column;
}

.date-main {
    font-weight: 500;
    color: var(--rp-gray-700);
}

.date-sub {
    font-size: 0.7rem;
    color: var(--rp-gray-400);
}

/* Badges */
.age-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    font-weight: 700;
    background: rgba(59, 130, 246, 0.1);
    color: var(--rp-accent);
    border-radius: 6px;
}

.sex-badge {
    display: inline-flex;
    padding: 0.25rem 0.65rem;
    font-size: 0.7rem;
    font-weight: 600;
    border-radius: 20px;
}

.badge-male {
    background: rgba(59, 130, 246, 0.1);
    color: var(--rp-accent);
}

.badge-female {
    background: rgba(244, 63, 94, 0.1);
    color: var(--rp-rose);
}

.purok-name {
    font-weight: 500;
    color: var(--rp-gray-700);
}

.address-cell {
    font-size: 0.8rem;
    color: var(--rp-gray-600);
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: block;
}

.contact-cell {
    font-weight: 500;
    color: var(--rp-emerald);
}

.status-badge {
    display: inline-flex;
    padding: 0.25rem 0.65rem;
    font-size: 0.7rem;
    font-weight: 600;
    background: var(--rp-gray-100);
    color: var(--rp-gray-600);
    border-radius: 20px;
}

.text-muted {
    color: var(--rp-gray-300);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100px;
    height: 100px;
    background: var(--rp-gray-100);
    border-radius: 50%;
    color: var(--rp-gray-400);
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--rp-gray-700);
    margin: 0 0 0.5rem;
}

.empty-state p {
    font-size: 0.95rem;
    color: var(--rp-gray-500);
    margin: 0 0 1.5rem;
}

.btn-back-empty {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--rp-accent);
    background: rgba(59, 130, 246, 0.1);
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-back-empty:hover {
    background: var(--rp-accent);
    color: white;
}

/* ===== Action Footer ===== */
.action-footer {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    animation: fadeInUp 0.6s ease-out backwards;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.75rem;
    font-size: 0.95rem;
    font-weight: 600;
    border-radius: var(--rp-radius-sm);
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, var(--rp-accent) 0%, var(--rp-violet) 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
}

.btn-success {
    background: linear-gradient(135deg, var(--rp-emerald) 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
}

.btn-secondary {
    background: white;
    color: var(--rp-gray-700);
    border: 2px solid var(--rp-gray-200);
}

.btn-secondary:hover {
    background: var(--rp-gray-50);
    border-color: var(--rp-gray-300);
    color: var(--rp-gray-800);
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
.dark .results-page {
    --rp-gray-50: #1e293b;
    --rp-gray-100: #334155;
    --rp-gray-200: #475569;
    --rp-gray-300: #64748b;
    --rp-gray-400: #94a3b8;
    --rp-gray-500: #cbd5e1;
    --rp-gray-600: #e2e8f0;
    --rp-gray-700: #f1f5f9;
    --rp-gray-800: #f8fafc;
    --rp-gray-900: #ffffff;
}

.dark .filter-summary,
.dark .stat-card-inner,
.dark .table-section {
    background: var(--rp-primary-light);
    border-color: var(--rp-gray-200);
}

.dark .section-header,
.dark .data-table th {
    background: rgba(0, 0, 0, 0.2);
}

.dark .btn-secondary {
    background: var(--rp-primary-light);
    border-color: var(--rp-gray-200);
    color: var(--rp-gray-300);
}

/* ===== Print Styles ===== */
@media print {
    .page-bg,
    .header-decoration,
    .no-print {
        display: none !important;
    }
    
    .results-page {
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
    
    .filter-summary,
    .stats-grid,
    .table-section {
        box-shadow: none;
        border: 1px solid #ddd;
    }
    
    .stat-card-inner {
        box-shadow: none;
        border: 1px solid #ddd;
    }
    
    .data-table th,
    .data-table td {
        padding: 0.5rem;
        font-size: 0.75rem;
    }
    
    .avatar {
        display: none;
    }
    
    @page {
        size: A4 landscape;
        margin: 10mm;
    }
}

/* ===== Responsive Adjustments ===== */
@media (max-width: 768px) {
    .results-page {
        padding: 1rem;
    }
    
    .page-header {
        padding: 1.5rem 1rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .filter-summary {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
        padding: 1rem;
    }
    
    .filter-divider {
        width: 100%;
        height: 1px;
    }
    
    .section-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .action-footer {
        flex-direction: column;
    }
    
    .action-btn {
        width: 100%;
        justify-content: center;
    }
    
    .data-table {
        font-size: 0.8rem;
    }
    
    .data-table th,
    .data-table td {
        padding: 0.625rem 0.5rem;
    }
    
    .avatar {
        width: 28px;
        height: 28px;
        font-size: 0.6rem;
    }
}
</style>
@endsection
