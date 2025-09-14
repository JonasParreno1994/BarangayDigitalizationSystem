@extends('layouts.adminLayout.index')

@section('title', 'Barangay Details Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Barangay Details</h3>
                    @if(!$barangayDetails)
                    <a href="{{ route('barangay-details.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Barangay Details
                    </a>
                    @endif
                </div>

                <div class="card-body">
                    @if($barangayDetails)
                    <div class="row">
                        <!-- Location Information -->
                        <div class="col-md-6">
                            <h5 class="text-primary">Location Information</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td><strong>Region:</strong></td>
                                    <td>{{ $barangayDetails->region ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Province:</strong></td>
                                    <td>{{ $barangayDetails->province ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>City/Municipality:</strong></td>
                                    <td>{{ $barangayDetails->city_municipality ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Barangay:</strong></td>
                                    <td>{{ $barangayDetails->barangay_name ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>District:</strong></td>
                                    <td>{{ $barangayDetails->district ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>ZIP Code:</strong></td>
                                    <td>{{ $barangayDetails->zip_code ?? 'Not set' }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Official Information -->
                        <div class="col-md-6">
                            <h5 class="text-primary">Officials</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td><strong>Captain:</strong></td>
                                    <td>{{ $barangayDetails->captain_name ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Secretary:</strong></td>
                                    <td>{{ $barangayDetails->secretary_name ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Treasurer:</strong></td>
                                    <td>{{ $barangayDetails->treasurer_name ?? 'Not set' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <!-- Contact Information -->
                        <div class="col-md-6">
                            <h5 class="text-primary">Contact Information</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $barangayDetails->barangay_contact ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $barangayDetails->barangay_email ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Emergency:</strong></td>
                                    <td>{{ $barangayDetails->emergency_contact ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Office Hours:</strong></td>
                                    <td>{{ $barangayDetails->office_hours ?? 'Not set' }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Fees -->
                        <div class="col-md-6">
                            <h5 class="text-primary">Document Fees</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td><strong>Clearance:</strong></td>
                                    <td>₱{{ number_format($barangayDetails->clearance_fee ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Residency:</strong></td>
                                    <td>₱{{ number_format($barangayDetails->residency_fee ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Indigency:</strong></td>
                                    <td>₱{{ number_format($barangayDetails->indigency_fee ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Good Moral:</strong></td>
                                    <td>₱{{ number_format($barangayDetails->good_moral_fee ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Death Certificate:</strong></td>
                                    <td>₱{{ number_format($barangayDetails->death_cert_fee ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Job Seeker:</strong></td>
                                    <td>₱{{ number_format($barangayDetails->jobseeker_fee ?? 0, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Logos Preview -->
                    @if($barangayDetails->logo1_path || $barangayDetails->logo2_path)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="text-primary">Logos</h5>
                            <div class="d-flex gap-3">
                                @if($barangayDetails->logo1_path)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" 
                                         alt="Logo 1" style="max-width: 100px; max-height: 100px;">
                                    <div class="small text-muted mt-1">Primary Logo</div>
                                </div>
                                @endif
                                @if($barangayDetails->logo2_path)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" 
                                         alt="Logo 2" style="max-width: 100px; max-height: 100px;">
                                    <div class="small text-muted mt-1">Secondary Logo</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <a href="{{ route('barangay-details.edit', $barangayDetails->id) }}" 
                               class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Details
                            </a>
                        </div>
                    </div>

                    @else
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle"></i> No Barangay Details Found</h5>
                        <p>Set up your barangay information to ensure all forms display correct details.</p>
                        <a href="{{ route('barangay-details.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Barangay Details
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
