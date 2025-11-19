@extends('layouts.adminLayout.index')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold text-primary mb-3">
            <i class="bi bi-graph-up-arrow"></i> Senior Citizen Prediction Analytics
        </h2>
        <p class="lead text-muted">Predict and plan for future senior citizens based on resident age data</p>
    </div>

    <!-- Quick Stats Cards -->
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
    @endphp

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white text-center p-4">
                    <i class="bi bi-calendar-event display-4 mb-3"></i>
                    <h3 class="display-4 fw-bold">{{ $currentYearCount }}</h3>
                    <p class="mb-0">Turning 60 This Year ({{ $currentYear }})</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 bg-gradient" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-white text-center p-4">
                    <i class="bi bi-calendar-plus display-4 mb-3"></i>
                    <h3 class="display-4 fw-bold">{{ $nextYearCount }}</h3>
                    <p class="mb-0">Turning 60 Next Year ({{ $nextYear }})</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 bg-gradient" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-white text-center p-4">
                    <i class="bi bi-people display-4 mb-3"></i>
                    <h3 class="display-4 fw-bold">{{ $totalFutureCount }}</h3>
                    <p class="mb-0">Next 5 Years ({{ $currentYear }}-{{ $currentYear + 5 }})</p>
                </div>
            </div>
        </div>
    </div>

    <!-- View Analytics Button -->
    <div class="text-center mb-5">
        <a href="{{ route('special-reports.senior-prediction-analytics') }}" class="btn btn-primary btn-lg shadow-lg px-5 py-3" target="_blank">
            <i class="bi bi-bar-chart-fill me-2"></i> View Data Visualization & Charts
        </a>
    </div>

    <!-- Report Generation Form -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top-4 py-3 text-center">
            <h3 class="mb-0 fw-bold">
                <i class="bi bi-file-earmark-bar-graph"></i> Generate Prediction Report
            </h3>
            <small class="text-light">Filter by year, purok, and month to generate detailed reports</small>
        </div>

        <div class="card-body bg-light p-4">
            <form id="predictionForm" action="{{ route('special-reports.generate-senior-prediction') }}" method="POST" target="_blank">
                @csrf

                <div class="row g-4 mb-4">
                    <!-- Prediction Year -->
                    <div class="col-md-4">
                        <label for="prediction_year" class="form-label fw-semibold">
                            <i class="bi bi-calendar3"></i> Prediction Year
                        </label>
                        <select class="form-select shadow-sm" id="prediction_year" name="prediction_year" required>
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
                        <small class="text-muted">Residents who will turn 60 in selected year</small>
                    </div>

                    <!-- Purok Filter -->
                    <div class="col-md-4">
                        <label for="purok_id" class="form-label fw-semibold">
                            <i class="bi bi-geo-alt"></i> Filter by Purok
                        </label>
                        <select class="form-select shadow-sm" id="purok_id" name="purok_id">
                            <option value="">All Puroks</option>
                            @foreach($puroks as $purok)
                                <option value="{{ $purok->id }}">{{ $purok->purok_name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Optional: Filter by specific purok</small>
                    </div>

                    <!-- Month Filter -->
                    <div class="col-md-4">
                        <label for="month" class="form-label fw-semibold">
                            <i class="bi bi-calendar-month"></i> Filter by Month
                        </label>
                        <select class="form-select shadow-sm" id="month" name="month">
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
                        <small class="text-muted">Optional: Filter by birth month</small>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 justify-content-center">
                    <button type="submit" class="btn btn-primary btn-lg shadow px-5">
                        <i class="bi bi-file-earmark-text me-2"></i> Generate Report
                    </button>
                    <button type="button" onclick="printReport()" class="btn btn-success btn-lg shadow px-5">
                        <i class="bi bi-printer me-2"></i> Print Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function printReport() {
            const form = document.getElementById('predictionForm');
            const predictionYear = document.getElementById('prediction_year').value;
            const purokId = document.getElementById('purok_id').value;
            const month = document.getElementById('month').value;
            
            // Build query string
            let params = new URLSearchParams();
            params.append('prediction_year', predictionYear);
            if (purokId) params.append('purok_id', purokId);
            if (month) params.append('month', month);
            
            // Open print page in new window
            window.open('{{ route('special-reports.print-senior-prediction') }}?' + params.toString(), '_blank');
        }
    </script>

    <!-- Information Card -->
    <div class="card border-info mt-5">
        <div class="card-body">
            <h5 class="card-title text-info">
                <i class="bi bi-info-circle-fill"></i> How It Works
            </h5>
            <p class="card-text mb-2">
                This prediction tool identifies residents who will turn 60 years old in the selected year, helping the barangay:
            </p>
            <ul class="mb-0">
                <li>Plan senior citizen benefits and services in advance</li>
                <li>Prepare budget allocations for incoming senior citizens</li>
                <li>Coordinate with relevant agencies for ID processing</li>
                <li>Conduct outreach programs for upcoming senior citizens</li>
                <li>Track demographic trends for policy planning</li>
            </ul>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
@endsection
