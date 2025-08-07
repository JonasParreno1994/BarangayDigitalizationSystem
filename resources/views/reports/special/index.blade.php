@extends('layouts.adminLayout.index')

@section('content')
@php
    $puroks = \App\Models\Purok::all();
@endphp
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top-4 py-3 text-center">
            <h3 class="mb-0 fw-bold">📊 Special Population Reports</h3>
            <small class="text-light">Filter and generate customized reports by population category</small>
        </div>

        <div class="card-body bg-light p-4">
            <form action="{{ route('special-reports.generate') }}" method="POST" target="_blank">
                @csrf

                <!-- Report Type -->
                <div class="row g-3 mb-4 align-items-end">
                    <div class="col-md-6 col-sm-12">
                        <label for="report_type" class="form-label fw-semibold">Report Type</label>
                        <select class="form-select shadow-sm" id="report_type" name="report_type" required>
                            <option value="seniors">👴 Senior Citizens</option>
                            <option value="pwds">♿ Persons with Disabilities (PWD)</option>
                            <option value="solo_parents">👩‍👧 Solo Parents</option>
                            <option value="all">📋 All Special Populations</option>
                        </select>
                    </div>
                </div>

                <!-- Senior Citizen Options -->
                <div class="row g-3 mb-4 align-items-end" id="senior_options" style="display: none;">
                    <div class="col-md-6 col-sm-12">
                        <label for="age_range" class="form-label fw-semibold">Age Range (for Seniors)</label>
                        <select class="form-select shadow-sm" id="age_range" name="age_range">
                            <option value="all">🧓 All Ages</option>
                            <option value="60-69">60-69 years old</option>
                            <option value="70-79">70-79 years old</option>
                            <option value="80+">80+ years old</option>
                        </select>
                    </div>
                </div>

                <!-- PWD Options -->
                <div class="row g-3 mb-4 align-items-end" id="pwd_options" style="display: none;">
                    <div class="col-md-6 col-sm-12">
                        <label for="pwd_type" class="form-label fw-semibold">PWD Type</label>
                        <select class="form-select shadow-sm" id="pwd_type" name="pwd_type">
                            <option value="all">♿ All Types</option>
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
                <div class="row g-3 mb-4 align-items-end" id="solo_parent_options" style="display: none;">
                    <div class="col-md-6 col-sm-12">
                        <label for="civil_status" class="form-label fw-semibold">Civil Status</label>
                        <select class="form-select shadow-sm" id="civil_status" name="civil_status">
                            <option value="all">📋 All Statuses</option>
                            <option value="Single">Single</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Separated">Separated</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success px-5 py-2 shadow-sm fw-semibold">
                        <i class="bi bi-bar-chart-fill me-2"></i> Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top-4 py-3 text-center">
            <h3 class="mb-0 fw-bold">🏘️ Purok Population Reports</h3>
            <small class="text-light">Generate reports filtered by purok and population characteristics</small>
        </div>

        <div class="card-body bg-light p-4">
            <form action="{{ route('special-reports.generate-purok') }}" method="POST" target="_blank">
                @csrf

                <div class="row g-3 mb-4">
                    <!-- Purok Selection -->
                    <div class="col-md-6 col-sm-12">
                        <label for="purok_id" class="form-label fw-semibold">Select Purok</label>
                        <select class="form-select shadow-sm" id="purok_id" name="purok_id" required>
                            <option value="">-- Select Purok --</option>
                            @foreach($puroks as $purok)
                                <option value="{{ $purok->id }}">{{ $purok->purok_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Population Type -->
                    <div class="col-md-6 col-sm-12">
                        <label for="report_type" class="form-label fw-semibold">Population Type</label>
                        <select class="form-select shadow-sm" id="report_type" name="report_type">
                            <option value="all">👥 All Residents</option>
                            <option value="seniors">👴 Senior Citizens</option>
                            <option value="pwds">♿ Persons with Disabilities</option>
                            <option value="solo_parents">👩‍👧 Solo Parents</option>
                        </select>
                    </div>

                    <!-- Gender Filter -->
                    <div class="col-md-4 col-sm-12">
                        <label for="gender" class="form-label fw-semibold">Gender</label>
                        <select class="form-select shadow-sm" id="gender" name="gender">
                            <option value="all">👫 All Genders</option>
                            <option value="Male">👨 Male</option>
                            <option value="Female">👩 Female</option>
                        </select>
                    </div>

                    <!-- Civil Status Filter -->
                    <div class="col-md-4 col-sm-12">
                        <label for="civil_status" class="form-label fw-semibold">Civil Status</label>
                        <select class="form-select shadow-sm" id="civil_status" name="civil_status">
                            <option value="all">💑 All Statuses</option>
                            <option value="Single">👤 Single</option>
                            <option value="Married">💍 Married</option>
                            <option value="Widowed">⚰️ Widowed</option>
                            <option value="Separated">💔 Separated</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm fw-semibold">
                        <i class="bi bi-file-earmark-text me-2"></i> Generate Purok Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Optional Styling --}}
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }
    .form-label {
        color: #333;
    }
    select.form-select, input.form-control {
        border-radius: 0.5rem;
    }
    button.btn-success {
        border-radius: 0.5rem;
        font-size: 1.1rem;
    }
</style>

{{-- JavaScript Logic --}}
<script>
    // Purok Report Form Validation
    document.querySelector('form[action="{{ route('special-reports.generate-purok') }}"]').addEventListener('submit', function(e) {
        const purokSelect = document.getElementById('purok_id');
        if (!purokSelect.value) {
            e.preventDefault();
            alert('Please select a purok');
            purokSelect.focus();
        }
    });

    // Dynamic filter options based on report type
    document.getElementById('report_type').addEventListener('change', function() {
        const reportType = this.value;
        const genderSelect = document.getElementById('gender');
        const civilStatusSelect = document.getElementById('civil_status');

        // Reset to default options
        genderSelect.value = 'all';
        civilStatusSelect.value = 'all';

        // Enable all options by default
        Array.from(genderSelect.options).forEach(option => option.disabled = false);
        Array.from(civilStatusSelect.options).forEach(option => option.disabled = false);

        // Customize options based on report type
        if (reportType === 'seniors') {
            // For seniors, you might want to disable certain civil status options
            // Example:
            // civilStatusSelect.querySelector('option[value="Single"]').disabled = true;
        } else if (reportType === 'solo_parents') {
            // For solo parents, you might want to disable "Single" if not applicable
            // civilStatusSelect.querySelector('option[value="Single"]').disabled = true;
        }
    });
</script>


<script>
    document.getElementById('report_type').addEventListener('change', function () {
        const value = this.value;

        document.getElementById('senior_options').style.display = 'none';
        document.getElementById('pwd_options').style.display = 'none';
        document.getElementById('solo_parent_options').style.display = 'none';

        if (value === 'seniors') {
            document.getElementById('senior_options').style.display = 'flex';
        } else if (value === 'pwds') {
            document.getElementById('pwd_options').style.display = 'flex';
        } else if (value === 'solo_parents') {
            document.getElementById('solo_parent_options').style.display = 'flex';
        } else if (value === 'all') {
            document.getElementById('senior_options').style.display = 'flex';
            document.getElementById('pwd_options').style.display = 'flex';
            document.getElementById('solo_parent_options').style.display = 'flex';
        }
    });

    // Trigger on page load in case of default value
    document.getElementById('report_type').dispatchEvent(new Event('change'));
</script>
@endsection
