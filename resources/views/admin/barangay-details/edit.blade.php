@extends('layouts.adminLayout.index')

@section('title', 'Edit Barangay Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Barangay Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('barangay-details.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <form action="{{ route('barangay-details.update', $barangayDetails->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Location Information -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-primary">Location Information</h5>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="region">Region</label>
                                    <input type="text" class="form-control @error('region') is-invalid @enderror" 
                                           id="region" name="region" value="{{ old('region', $barangayDetails->region) }}">
                                    @error('region')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="province">Province</label>
                                    <input type="text" class="form-control @error('province') is-invalid @enderror" 
                                           id="province" name="province" value="{{ old('province', $barangayDetails->province) }}">
                                    @error('province')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city_municipality">City/Municipality <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('city_municipality') is-invalid @enderror" 
                                           id="city_municipality" name="city_municipality" value="{{ old('city_municipality', $barangayDetails->city_municipality) }}" required>
                                    @error('city_municipality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="barangay_name">Barangay Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('barangay_name') is-invalid @enderror" 
                                           id="barangay_name" name="barangay_name" value="{{ old('barangay_name', $barangayDetails->barangay_name) }}" required>
                                    @error('barangay_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Official Information -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="text-primary">Officials</h5>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="captain_name">Barangay Captain</label>
                                    <input type="text" class="form-control @error('captain_name') is-invalid @enderror" 
                                           id="captain_name" name="captain_name" value="{{ old('captain_name', $barangayDetails->captain_name) }}">
                                    @error('captain_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="secretary_name">Barangay Secretary</label>
                                    <input type="text" class="form-control @error('secretary_name') is-invalid @enderror" 
                                           id="secretary_name" name="secretary_name" value="{{ old('secretary_name', $barangayDetails->secretary_name) }}">
                                    @error('secretary_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="treasurer_name">Barangay Treasurer</label>
                                    <input type="text" class="form-control @error('treasurer_name') is-invalid @enderror" 
                                           id="treasurer_name" name="treasurer_name" value="{{ old('treasurer_name', $barangayDetails->treasurer_name) }}">
                                    @error('treasurer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Document Fees -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="text-primary">Document Fees</h5>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="clearance_fee">Clearance Fee (₱)</label>
                                    <input type="number" step="0.01" class="form-control @error('clearance_fee') is-invalid @enderror" 
                                           id="clearance_fee" name="clearance_fee" value="{{ old('clearance_fee', $barangayDetails->clearance_fee) }}">
                                    @error('clearance_fee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="residency_fee">Residency Fee (₱)</label>
                                    <input type="number" step="0.01" class="form-control @error('residency_fee') is-invalid @enderror" 
                                           id="residency_fee" name="residency_fee" value="{{ old('residency_fee', $barangayDetails->residency_fee) }}">
                                    @error('residency_fee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="indigency_fee">Indigency Fee (₱)</label>
                                    <input type="number" step="0.01" class="form-control @error('indigency_fee') is-invalid @enderror" 
                                           id="indigency_fee" name="indigency_fee" value="{{ old('indigency_fee', $barangayDetails->indigency_fee) }}">
                                    @error('indigency_fee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Current Logos Display -->
                        @if($barangayDetails->logo1_path || $barangayDetails->logo2_path)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="text-primary">Current Logos</h5>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            @if($barangayDetails->logo1_path)
                            <div class="col-md-6">
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" 
                                         alt="Primary Logo" class="img-fluid" style="max-height: 150px;">
                                    <p class="small text-muted mt-2">Current Primary Logo</p>
                                </div>
                            </div>
                            @endif
                            @if($barangayDetails->logo2_path)
                            <div class="col-md-6">
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" 
                                         alt="Secondary Logo" class="img-fluid" style="max-height: 150px;">
                                    <p class="small text-muted mt-2">Current Secondary Logo</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- File Uploads -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="text-primary">Update Logos & Signatures</h5>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logo1">Primary Logo <small class="text-muted">(leave empty to keep current)</small></label>
                                    <input type="file" class="form-control-file @error('logo1') is-invalid @enderror" 
                                           id="logo1" name="logo1" accept="image/*">
                                    @error('logo1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logo2">Secondary Logo <small class="text-muted">(leave empty to keep current)</small></label>
                                    <input type="file" class="form-control-file @error('logo2') is-invalid @enderror" 
                                           id="logo2" name="logo2" accept="image/*">
                                    @error('logo2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $barangayDetails->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Barangay Details
                        </button>
                        <a href="{{ route('barangay-details.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
