@extends('layouts.adminLayout.index')

@section('content')
@php
    $puroks = \App\Models\Purok::all();
    
    // Quick stats
    $totalSeniors = \App\Models\ResidentModel::where('is_senior_citizen', true)->count();
    $totalPWD = \App\Models\ResidentModel::where('is_pwd', true)->count();
    $totalSoloParents = \App\Models\ResidentModel::where('is_solo_parent', true)->count();
    $totalResidents = \App\Models\ResidentModel::count();
@endphp

<div class="special-reports-page">
    <!-- Animated Background -->
    <div class="page-bg"></div>
    
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <h1 class="page-title">Special Reports</h1>
            <p class="page-subtitle">Generate customized population reports and demographic analysis</p>
        </div>
        <div class="header-decoration">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="quick-stats" style="animation-delay: 0.1s">
        <div class="stat-item">
            <div class="stat-icon icon-violet">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-data">
                <span class="stat-value">{{ number_format($totalSeniors) }}</span>
                <span class="stat-label">Senior Citizens</span>
            </div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-icon icon-blue">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 8v8"></path>
                    <path d="M8 12h8"></path>
                </svg>
            </div>
            <div class="stat-data">
                <span class="stat-value">{{ number_format($totalPWD) }}</span>
                <span class="stat-label">PWD</span>
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
                <span class="stat-value">{{ number_format($totalSoloParents) }}</span>
                <span class="stat-label">Solo Parents</span>
            </div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-icon icon-emerald">
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
    </div>

    <!-- Quick Access Cards -->
    <div class="quick-access" style="animation-delay: 0.15s">
        <a href="{{ route('special-reports.senior-prediction') }}" class="quick-card">
            <div class="quick-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
            </div>
            <div class="quick-card-content">
                <h4>Senior Prediction Analytics</h4>
                <p>Forecast future senior citizens with data visualization</p>
            </div>
            <div class="quick-card-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </div>
        </a>
    </div>

    <!-- Report Cards Grid -->
    <div class="reports-grid">
        <!-- Special Population Reports -->
        <div class="report-card" style="animation-delay: 0.2s">
            <div class="report-card-header header-violet">
                <div class="report-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div class="report-title-wrap">
                    <h3>Special Population Reports</h3>
                    <p>Filter by population category</p>
                </div>
            </div>
            <div class="report-card-body">
                <form action="{{ route('special-reports.generate') }}" method="POST" target="_blank" id="specialPopForm">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                            </svg>
                            Report Type
                        </label>
                        <div class="select-wrapper">
                            <select class="form-select" id="report_type_special" name="report_type" required>
                                <option value="seniors">Senior Citizens (60+)</option>
                                <option value="pwds">Persons with Disabilities</option>
                                <option value="solo_parents">Solo Parents</option>
                                <option value="all">All Special Populations</option>
                            </select>
                        </div>
                    </div>

                    <!-- Senior Options -->
                    <div class="form-group conditional-field" id="senior_options">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            Age Range
                        </label>
                        <div class="select-wrapper">
                            <select class="form-select" id="age_range" name="age_range">
                                <option value="all">All Ages (60+)</option>
                                <option value="60-69">60-69 years old</option>
                                <option value="70-79">70-79 years old</option>
                                <option value="80+">80+ years old</option>
                            </select>
                        </div>
                    </div>

                    <!-- PWD Options -->
                    <div class="form-group conditional-field" id="pwd_options" style="display: none;">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 8v8"></path>
                                <path d="M8 12h8"></path>
                            </svg>
                            PWD Type
                        </label>
                        <div class="select-wrapper">
                            <select class="form-select" id="pwd_type" name="pwd_type">
                                <option value="all">All Types</option>
                                <option value="Physical">Physical Disability</option>
                                <option value="Visual">Visual Impairment</option>
                                <option value="Hearing">Hearing Impairment</option>
                                <option value="Intellectual">Intellectual Disability</option>
                                <option value="Psychosocial">Psychosocial Disability</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Solo Parent Options -->
                    <div class="form-group conditional-field" id="solo_parent_options" style="display: none;">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Civil Status
                        </label>
                        <div class="select-wrapper">
                            <select class="form-select" id="civil_status_special" name="civil_status">
                                <option value="all">All Statuses</option>
                                <option value="Single">Single</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Separated">Separated</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn-generate btn-violet">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                        Generate Report
                    </button>
                </form>
            </div>
        </div>

        <!-- Purok Population Reports -->
        <div class="report-card" style="animation-delay: 0.3s">
            <div class="report-card-header header-emerald">
                <div class="report-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <div class="report-title-wrap">
                    <h3>Purok Population Reports</h3>
                    <p>Filter by geographic area</p>
                </div>
            </div>
            <div class="report-card-body">
                <form action="{{ route('special-reports.generate-purok') }}" method="POST" target="_blank" id="purokForm">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Select Purok
                            </label>
                            <div class="select-wrapper">
                                <select class="form-select" id="purok_id" name="purok_id" required>
                                    <option value="">-- Select Purok --</option>
                                    @foreach($puroks as $purok)
                                        <option value="{{ $purok->id }}">{{ $purok->purok_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                </svg>
                                Population Type
                            </label>
                            <div class="select-wrapper">
                                <select class="form-select" id="report_type_purok" name="report_type">
                                    <option value="all">All Residents</option>
                                    <option value="seniors">Senior Citizens</option>
                                    <option value="pwds">PWD</option>
                                    <option value="solo_parents">Solo Parents</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 8v8"></path>
                                </svg>
                                Gender
                            </label>
                            <div class="select-wrapper">
                                <select class="form-select" id="gender" name="gender">
                                    <option value="all">All Genders</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Civil Status
                            </label>
                            <div class="select-wrapper">
                                <select class="form-select" id="civil_status_purok" name="civil_status">
                                    <option value="all">All Statuses</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-generate btn-emerald">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                        Generate Purok Report
                    </button>
                </form>
            </div>
        </div>

        <!-- Age Bracket Reports -->
        <div class="report-card" style="animation-delay: 0.4s">
            <div class="report-card-header header-amber">
                <div class="report-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                </div>
                <div class="report-title-wrap">
                    <h3>Age Bracket Reports</h3>
                    <p>Generate reports by age groups</p>
                </div>
            </div>
            <div class="report-card-body">
                <form action="{{ route('special-reports.generate-age-bracket') }}" method="POST" target="_blank">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            Age Bracket
                        </label>
                        <div class="select-wrapper">
                            <select class="form-select" id="age_bracket" name="age_bracket" required>
                                <option value="all">All Ages</option>
                                <optgroup label="Children & Youth">
                                    <option value="5-9">5-9 years old</option>
                                    <option value="10-14">10-14 years old</option>
                                    <option value="15-19">15-19 years old</option>
                                </optgroup>
                                <optgroup label="Young Adults">
                                    <option value="20-24">20-24 years old</option>
                                    <option value="25-29">25-29 years old</option>
                                </optgroup>
                                <optgroup label="Adults">
                                    <option value="30-34">30-34 years old</option>
                                    <option value="35-39">35-39 years old</option>
                                    <option value="40-44">40-44 years old</option>
                                    <option value="45-49">45-49 years old</option>
                                    <option value="50-59">50-59 years old</option>
                                </optgroup>
                                <optgroup label="Senior Citizens">
                                    <option value="60-64">60-64 years old</option>
                                    <option value="65-69">65-69 years old</option>
                                    <option value="70-74">70-74 years old</option>
                                    <option value="75-79">75-79 years old</option>
                                    <option value="80+">80+ years old</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="age-bracket-visual">
                        <div class="bracket-bar" data-label="Children" style="width: 15%;"></div>
                        <div class="bracket-bar" data-label="Youth" style="width: 20%;"></div>
                        <div class="bracket-bar" data-label="Adults" style="width: 40%;"></div>
                        <div class="bracket-bar" data-label="Seniors" style="width: 25%;"></div>
                    </div>

                    <button type="submit" class="btn-generate btn-amber">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                        Generate Age Report
                    </button>
                </form>
            </div>
        </div>

        <!-- Sector Population Reports -->
        <div class="report-card" style="animation-delay: 0.5s">
            <div class="report-card-header header-rose">
                <div class="report-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </div>
                <div class="report-title-wrap">
                    <h3>Sector Population Reports</h3>
                    <p>Generate by population sectors</p>
                </div>
            </div>
            <div class="report-card-body">
                <form action="{{ route('special-reports.generate-sector') }}" method="POST" target="_blank">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            </svg>
                            Sector Type
                        </label>
                        <div class="select-wrapper">
                            <select class="form-select" id="sector_type" name="sector_type" required>
                                <option value="labor_force">Labor Force (Employed)</option>
                                <option value="unemployed">Unemployed</option>
                                <option value="out_of_school_children">Out of School Children (6-14 yrs)</option>
                                <option value="out_of_school_youth">Out of School Youth (15-24 yrs)</option>
                                <option value="ofw">Overseas Filipino Workers (OFW)</option>
                                <option value="indigenous">Indigenous People (IPs)</option>
                            </select>
                        </div>
                    </div>

                    <div class="sector-tags">
                        <span class="sector-tag tag-labor">Labor Force</span>
                        <span class="sector-tag tag-education">Education</span>
                        <span class="sector-tag tag-special">Special Groups</span>
                    </div>

                    <button type="submit" class="btn-generate btn-rose">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                        Generate Sector Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reportTypeSelect = document.getElementById('report_type_special');
    const seniorOptions = document.getElementById('senior_options');
    const pwdOptions = document.getElementById('pwd_options');
    const soloParentOptions = document.getElementById('solo_parent_options');

    function toggleOptions() {
        const value = reportTypeSelect.value;
        
        seniorOptions.style.display = 'none';
        pwdOptions.style.display = 'none';
        soloParentOptions.style.display = 'none';

        if (value === 'seniors') {
            seniorOptions.style.display = 'block';
        } else if (value === 'pwds') {
            pwdOptions.style.display = 'block';
        } else if (value === 'solo_parents') {
            soloParentOptions.style.display = 'block';
        } else if (value === 'all') {
            seniorOptions.style.display = 'block';
            pwdOptions.style.display = 'block';
            soloParentOptions.style.display = 'block';
        }
    }

    reportTypeSelect.addEventListener('change', toggleOptions);
    toggleOptions();

    // Purok form validation
    document.getElementById('purokForm').addEventListener('submit', function(e) {
        const purokSelect = document.getElementById('purok_id');
        if (!purokSelect.value) {
            e.preventDefault();
            purokSelect.focus();
            purokSelect.classList.add('error');
            setTimeout(() => purokSelect.classList.remove('error'), 2000);
        }
    });
});
</script>

<style>
/* ===== CSS Variables ===== */
:root {
    --sr-primary: #0f172a;
    --sr-primary-light: #1e293b;
    --sr-accent: #3b82f6;
    --sr-accent-light: #60a5fa;
    --sr-violet: #8b5cf6;
    --sr-violet-light: #a78bfa;
    --sr-emerald: #10b981;
    --sr-emerald-light: #34d399;
    --sr-amber: #f59e0b;
    --sr-amber-light: #fbbf24;
    --sr-rose: #f43f5e;
    --sr-rose-light: #fb7185;
    --sr-gray-50: #f8fafc;
    --sr-gray-100: #f1f5f9;
    --sr-gray-200: #e2e8f0;
    --sr-gray-300: #cbd5e1;
    --sr-gray-400: #94a3b8;
    --sr-gray-500: #64748b;
    --sr-gray-600: #475569;
    --sr-gray-700: #334155;
    --sr-gray-800: #1e293b;
    --sr-gray-900: #0f172a;
    --sr-radius: 16px;
    --sr-radius-sm: 10px;
    --sr-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --sr-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
}

/* ===== Page Container ===== */
.special-reports-page {
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
        radial-gradient(ellipse at 0% 0%, rgba(139, 92, 246, 0.08) 0%, transparent 50%),
        radial-gradient(ellipse at 100% 0%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
        radial-gradient(ellipse at 100% 100%, rgba(244, 63, 94, 0.05) 0%, transparent 50%),
        radial-gradient(ellipse at 0% 100%, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
    pointer-events: none;
    z-index: -1;
}

/* ===== Header Section ===== */
.page-header {
    position: relative;
    text-align: center;
    padding: 2.5rem 2rem;
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, var(--sr-primary) 0%, var(--sr-primary-light) 100%);
    border-radius: var(--sr-radius);
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
    background: linear-gradient(135deg, var(--sr-violet) 0%, var(--sr-accent) 100%);
    border-radius: 20px;
    margin-bottom: 1.25rem;
    color: white;
    box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
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
    color: var(--sr-gray-300);
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
    width: 250px;
    height: 250px;
    background: var(--sr-violet);
    top: -80px;
    right: -40px;
    animation: float 8s ease-in-out infinite;
}

.shape-2 {
    width: 180px;
    height: 180px;
    background: var(--sr-accent);
    bottom: -40px;
    left: 10%;
    animation: float 6s ease-in-out infinite reverse;
}

.shape-3 {
    width: 120px;
    height: 120px;
    background: var(--sr-emerald);
    top: 20%;
    left: -20px;
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
    border-radius: var(--sr-radius-sm);
    border: 1px solid var(--sr-gray-200);
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 10px;
}

.icon-violet { background: rgba(139, 92, 246, 0.1); color: var(--sr-violet); }
.icon-blue { background: rgba(59, 130, 246, 0.1); color: var(--sr-accent); }
.icon-rose { background: rgba(244, 63, 94, 0.1); color: var(--sr-rose); }
.icon-emerald { background: rgba(16, 185, 129, 0.1); color: var(--sr-emerald); }

.stat-data {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--sr-gray-900);
    line-height: 1;
}

.stat-label {
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--sr-gray-500);
    margin-top: 0.15rem;
}

.stat-divider {
    width: 1px;
    height: 40px;
    background: var(--sr-gray-200);
}

/* ===== Quick Access ===== */
.quick-access {
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

.quick-card {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, var(--sr-accent) 0%, var(--sr-violet) 100%);
    border-radius: var(--sr-radius-sm);
    text-decoration: none;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.quick-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

.quick-card-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 52px;
    height: 52px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    flex-shrink: 0;
}

.quick-card-content {
    flex: 1;
}

.quick-card-content h4 {
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0 0 0.25rem;
}

.quick-card-content p {
    font-size: 0.85rem;
    margin: 0;
    opacity: 0.85;
}

.quick-card-arrow {
    opacity: 0.7;
    transition: transform 0.3s ease;
}

.quick-card:hover .quick-card-arrow {
    transform: translateX(4px);
    opacity: 1;
}

/* ===== Reports Grid ===== */
.reports-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

@media (max-width: 992px) {
    .reports-grid { grid-template-columns: 1fr; }
}

/* ===== Report Card ===== */
.report-card {
    background: white;
    border-radius: var(--sr-radius);
    border: 1px solid var(--sr-gray-200);
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out backwards;
    transition: all 0.3s ease;
}

.report-card:hover {
    box-shadow: var(--sr-shadow-lg);
}

.report-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    color: white;
}

.header-violet { background: linear-gradient(135deg, var(--sr-violet) 0%, #7c3aed 100%); }
.header-emerald { background: linear-gradient(135deg, var(--sr-emerald) 0%, #059669 100%); }
.header-amber { background: linear-gradient(135deg, var(--sr-amber) 0%, #d97706 100%); }
.header-rose { background: linear-gradient(135deg, var(--sr-rose) 0%, #e11d48 100%); }

.report-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    flex-shrink: 0;
}

.report-title-wrap h3 {
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0 0 0.15rem;
}

.report-title-wrap p {
    font-size: 0.8rem;
    margin: 0;
    opacity: 0.85;
}

.report-card-body {
    padding: 1.5rem;
}

/* ===== Form Styles ===== */
.form-group {
    margin-bottom: 1rem;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

@media (max-width: 640px) {
    .form-row { grid-template-columns: 1fr; }
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--sr-gray-700);
    margin-bottom: 0.5rem;
}

.form-label svg {
    color: var(--sr-gray-400);
}

.select-wrapper {
    position: relative;
}

.form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    padding-right: 2.5rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--sr-gray-800);
    background: var(--sr-gray-50);
    border: 2px solid var(--sr-gray-200);
    border-radius: var(--sr-radius-sm);
    appearance: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.form-select:hover {
    border-color: var(--sr-gray-300);
}

.form-select:focus {
    outline: none;
    border-color: var(--sr-accent);
    background: white;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.form-select.error {
    border-color: var(--sr-rose);
    animation: shake 0.4s ease;
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
    border-top: 6px solid var(--sr-gray-400);
    pointer-events: none;
}

.conditional-field {
    animation: fadeIn 0.3s ease;
}

/* ===== Generate Buttons ===== */
.btn-generate {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    width: 100%;
    padding: 0.875rem 1.5rem;
    font-size: 0.95rem;
    font-weight: 600;
    color: white;
    border: none;
    border-radius: var(--sr-radius-sm);
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.5rem;
}

.btn-violet {
    background: linear-gradient(135deg, var(--sr-violet) 0%, #7c3aed 100%);
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
}
.btn-violet:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(139, 92, 246, 0.5);
}

.btn-emerald {
    background: linear-gradient(135deg, var(--sr-emerald) 0%, #059669 100%);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}
.btn-emerald:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
}

.btn-amber {
    background: linear-gradient(135deg, var(--sr-amber) 0%, #d97706 100%);
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
}
.btn-amber:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.5);
}

.btn-rose {
    background: linear-gradient(135deg, var(--sr-rose) 0%, #e11d48 100%);
    box-shadow: 0 4px 15px rgba(244, 63, 94, 0.4);
}
.btn-rose:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(244, 63, 94, 0.5);
}

/* ===== Age Bracket Visual ===== */
.age-bracket-visual {
    display: flex;
    gap: 4px;
    margin: 1rem 0 0.5rem;
    height: 8px;
    border-radius: 4px;
    overflow: hidden;
}

.bracket-bar {
    height: 100%;
    border-radius: 2px;
    position: relative;
}

.bracket-bar:nth-child(1) { background: var(--sr-accent); }
.bracket-bar:nth-child(2) { background: var(--sr-emerald); }
.bracket-bar:nth-child(3) { background: var(--sr-amber); }
.bracket-bar:nth-child(4) { background: var(--sr-violet); }

/* ===== Sector Tags ===== */
.sector-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin: 1rem 0 0.5rem;
}

.sector-tag {
    display: inline-flex;
    padding: 0.35rem 0.75rem;
    font-size: 0.7rem;
    font-weight: 600;
    border-radius: 20px;
}

.tag-labor { background: rgba(59, 130, 246, 0.1); color: var(--sr-accent); }
.tag-education { background: rgba(245, 158, 11, 0.1); color: var(--sr-amber); }
.tag-special { background: rgba(139, 92, 246, 0.1); color: var(--sr-violet); }

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

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* ===== Dark Mode Support ===== */
.dark .special-reports-page {
    --sr-gray-50: #1e293b;
    --sr-gray-100: #334155;
    --sr-gray-200: #475569;
    --sr-gray-300: #64748b;
    --sr-gray-400: #94a3b8;
    --sr-gray-500: #cbd5e1;
    --sr-gray-600: #e2e8f0;
    --sr-gray-700: #f1f5f9;
    --sr-gray-800: #f8fafc;
    --sr-gray-900: #ffffff;
}

.dark .quick-stats,
.dark .report-card {
    background: var(--sr-primary-light);
    border-color: var(--sr-gray-200);
}

.dark .form-select {
    background: var(--sr-primary);
    color: white;
}

/* ===== Responsive Adjustments ===== */
@media (max-width: 768px) {
    .special-reports-page {
        padding: 1rem;
    }
    
    .page-header {
        padding: 2rem 1.5rem;
    }
    
    .page-title {
        font-size: 1.75rem;
    }
    
    .quick-stats {
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
    }
    
    .stat-divider {
        width: 100%;
        height: 1px;
    }
    
    .quick-card {
        flex-direction: column;
        text-align: center;
    }
    
    .quick-card-arrow {
        display: none;
    }
    
    .report-card-header {
        flex-direction: column;
        text-align: center;
    }
    
    .report-card-body {
        padding: 1.25rem;
    }
}
</style>
@endsection
