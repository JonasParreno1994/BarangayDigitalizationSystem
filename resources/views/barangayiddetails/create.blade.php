@extends('layouts.adminLayout.index')
@section('content')
<div class="content">
    <div class="page-header mb-4">
        <div class="page-title">
            <h4 class="mb-1">Create Barangay ID Template</h4>
            <p class="text-muted mb-0">Configure the design elements for the Barangay Identification Cards</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0">Template Configuration</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('barangayid.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <!-- Logos Section -->
                    <div class="col-12">
                        <div class="section-header mb-3">
                            <h6 class="section-title text-primary"><i class="fas fa-images me-2"></i> Logos</h6>
                            <p class="text-muted small">Upload official logos for the ID card</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Primary Logo</label>
                            <div class="file-upload-container">
                                <input type="file" name="logo1" class="form-control" accept="image/*" required>
                                <small class="form-text text-muted">Recommended size: 150x150px (PNG with transparent background)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Secondary Logo</label>
                            <div class="file-upload-container">
                                <input type="file" name="logo2" class="form-control" accept="image/*" required>
                                <small class="form-text text-muted">Recommended size: 150x150px (PNG with transparent background)</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Headings Section -->
                    <div class="col-12 mt-4">
                        <div class="section-header mb-3">
                            <h6 class="section-title text-primary"><i class="fas fa-heading me-2"></i> Headings</h6>
                            <p class="text-muted small">Configure the text elements for the ID card</p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Heading 1</label>
                            <input type="text" name="heading1" class="form-control" placeholder="e.g. Republic of the Philippines" required>
                            <small class="form-text text-muted">Main heading text</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Heading 2</label>
                            <input type="text" name="heading2" class="form-control" placeholder="e.g. Province of..." required>
                            <small class="form-text text-muted">Secondary heading text</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Heading 3</label>
                            <input type="text" name="heading3" class="form-control" placeholder="e.g. Barangay..." required>
                            <small class="form-text text-muted">Tertiary heading text</small>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Validity Period</label>
                            <input type="text" name="validity" class="form-control" placeholder="e.g. 1 year" required>
                            <small class="form-text text-muted">ID card expiration duration</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Barangay Captain Name</label>
                            <input type="text" name="pass_captain" class="form-control" placeholder="e.g. Juan Dela Cruz" required>
                            <small class="form-text text-muted">Full name of the Barangay Captain</small>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Additional Details</label>
                            <textarea name="details" class="form-control" rows="3" placeholder="Enter any additional terms, conditions, or information to be displayed on the ID..." required></textarea>
                            <small class="form-text text-muted">This text will appear on the back of the ID card</small>
                        </div>
                    </div>
                    
                    <!-- Signature Section -->
                    <div class="col-12">
                        <div class="section-header mb-3">
                            <h6 class="section-title text-primary"><i class="fas fa-signature me-2"></i> Authorization</h6>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group mb-4">
                            <label class="form-label fw-semibold">Signature Image</label>
                            <div class="file-upload-container">
                                <input type="file" name="signature" class="form-control" accept="image/*" required>
                                <small class="form-text text-muted">Upload a clear signature image (Recommended size: 300x100px)</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-end border-top pt-4">
                             <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i> Save Template
                            </button> <br>
                            <a href="{{ route('barangayid.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .section-header {
        padding: 0.75rem 1.25rem;
        background-color: #f8f9fa;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.05rem;
        margin-bottom: 0.25rem;
    }
    
    .file-upload-container {
        border: 1px dashed #dee2e6;
        padding: 1.25rem;
        border-radius: 0.375rem;
        background-color: #f8f9fa;
    }
    
    .card {
        border-radius: 0.5rem;
    }
    
    .form-label {
        margin-bottom: 0.5rem;
    }
</style>
@endsection