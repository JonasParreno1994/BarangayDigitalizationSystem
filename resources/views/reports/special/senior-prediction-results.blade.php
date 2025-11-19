@extends('layouts.adminLayout.index')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-graph-up-arrow"></i> Senior Citizen Prediction Report
            </h4>
            <small>Residents who will turn 60 years old in {{ $predictionYear }}</small>
        </div>

        <div class="card-body">
            <!-- Report Info -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Prediction Year:</strong> {{ $predictionYear }}
                            </div>
                            <div class="col-md-3">
                                <strong>Month:</strong> {{ $month ? date('F', mktime(0, 0, 0, $month, 1)) : 'All Months' }}
                            </div>
                            <div class="col-md-3">
                                <strong>Purok:</strong> {{ $purok ? $purok->purok_name : 'All Puroks' }}
                            </div>
                            <div class="col-md-3">
                                <strong>Total Count:</strong> {{ $residents->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h3 class="text-primary">{{ $residents->where('sex', 'Male')->count() }}</h3>
                            <p class="mb-0">Male</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h3 class="text-danger">{{ $residents->where('sex', 'Female')->count() }}</h3>
                            <p class="mb-0">Female</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h3 class="text-success">{{ $residents->whereNotNull('purok_id')->count() }}</h3>
                            <p class="mb-0">With Purok</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h3 class="text-warning">{{ $residents->whereNotNull('contact_number')->count() }}</h3>
                            <p class="mb-0">With Contact</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Residents Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="predictionTable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Birth Date</th>
                            <th>Current Age</th>
                            <th>Sex</th>
                            <th>Purok</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th>Civil Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($residents as $resident)
                        <tr>
                            <td>{{ $resident->id }}</td>
                            <td>
                                <strong>{{ $resident->full_name }}</strong>
                            </td>
                            <td>{{ $resident->birth_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-info">{{ $resident->age }} years old</span>
                            </td>
                            <td>
                                @if($resident->sex == 'Male')
                                    <span class="badge bg-primary">Male</span>
                                @else
                                    <span class="badge bg-danger">Female</span>
                                @endif
                            </td>
                            <td>{{ $resident->purok->purok_name ?? 'N/A' }}</td>
                            <td>{{ $resident->address ?? 'N/A' }}</td>
                            <td>{{ $resident->contact_number ?? 'N/A' }}</td>
                            <td>{{ $resident->civil_status ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <p class="text-muted mt-2">No residents found for the selected criteria</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 text-center no-print">
                <button onclick="printReport()" class="btn btn-success btn-lg shadow">
                    <i class="bi bi-printer"></i> Print Report
                </button>
                <button onclick="exportToExcel()" class="btn btn-primary btn-lg shadow">
                    <i class="bi bi-file-earmark-excel"></i> Export to Excel
                </button>
                <a href="{{ route('special-reports.senior-prediction') }}" class="btn btn-secondary btn-lg shadow">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>
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
        
        // Open official print format in new window
        window.open('{{ route('special-reports.print-senior-prediction') }}?' + params.toString(), '_blank');
    }

    function exportToExcel() {
        const table = document.getElementById('predictionTable');
        const wb = XLSX.utils.table_to_book(table, {sheet: "Predictions"});
        XLSX.writeFile(wb, 'senior_citizen_predictions_{{ $predictionYear }}.xlsx');
    }
</script>

<!-- Include SheetJS for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<style>
@media print {
    .no-print { 
        display: none !important; 
    }
    .card { 
        border: 1px solid #000 !important; 
        box-shadow: none !important; 
        page-break-inside: avoid;
    }
    .card-header {
        background-color: #333 !important;
        color: white !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .alert {
        border: 1px solid #000 !important;
        page-break-inside: avoid;
    }
    .table {
        page-break-inside: auto;
    }
    .table tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    .table thead {
        display: table-header-group;
    }
    .table-dark {
        background-color: #333 !important;
        color: white !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .badge {
        border: 1px solid #000;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    body {
        margin: 0;
        padding: 15px;
    }
    @page {
        size: A4 landscape;
        margin: 15mm;
    }
}
</style>
@endsection
