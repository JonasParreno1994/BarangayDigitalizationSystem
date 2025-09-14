@extends('layouts.adminLayout.index')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top-4 py-4 text-center">
            <h3 class="mb-0 fw-bold">📋 RBI Form C - Monitoring Report</h3>
            <small class="text-light">Generate Barangay Population Monitoring Report for BHW Data</small>
        </div>
        
        <div class="card-body bg-light p-4">
            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                </div>
            @endif

            <div class="alert alert-info mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle me-2"></i>
                    <div>
                        <strong>About RBI Form C:</strong> This report generates population data by age brackets, labor force statistics, and special population categories as required for Barangay Health Worker (BHW) monitoring.
                    </div>
                </div>
            </div>

            <form action="{{ route('rbi-form-c.generate') }}" method="POST" target="_blank">
                @csrf
                
                <div class="row g-4 mb-4">
                    <!-- Report Semester -->
                    <div class="col-md-6">
                        <label for="report_semester" class="form-label fw-semibold">
                            <i class="fas fa-calendar-alt me-2"></i>Report Semester
                        </label>
                        <select class="form-select shadow-sm" id="report_semester" name="report_semester" required>
                            <option value="">Select Semester</option>
                            <option value="first">📅 1st Semester (January - June)</option>
                            <option value="second">📅 2nd Semester (July - December)</option>
                        </select>
                    </div>
                    
                    <!-- Report Year -->
                    <div class="col-md-6">
                        <label for="report_year" class="form-label fw-semibold">
                            <i class="fas fa-calendar me-2"></i>Report Year
                        </label>
                        <select class="form-select shadow-sm" id="report_year" name="report_year" required>
                            <option value="">Select Year</option>
                            @for($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="alert alert-light border rounded-3 mb-4">
                    <h6 class="fw-bold mb-3">📊 Report Contents Preview:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-2">Population by Age Bracket:</h6>
                            <ul class="list-unstyled small text-muted mb-3">
                                <li>• Under 5 years to 85+ years</li>
                                <li>• Separated by Male/Female</li>
                                <li>• Total population count</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary mb-2">Special Categories:</h6>
                            <ul class="list-unstyled small text-muted mb-3">
                                <li>• Labor Force & Unemployed</li>
                                <li>• Out of School Children/Youth</li>
                                <li>• Persons with Disabilities</li>
                                <li>• Overseas Filipino Workers</li>
                                <li>• Indigenous People</li>
                                <li>• Citizenship breakdown</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                        <i class="fas fa-file-alt me-2"></i>Generate RBI Form C Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .card {
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .form-select, .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        transition: all 0.3s ease;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    }
    
    .alert-info {
        background: linear-gradient(135deg, #d1ecf1, #bee5eb);
        border: none;
        border-left: 4px solid #17a2b8;
    }
    
    .alert-light {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
    }
</style>
@endsection
