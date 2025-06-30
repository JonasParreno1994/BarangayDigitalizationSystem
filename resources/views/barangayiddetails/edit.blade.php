@extends('layouts.adminLayout.index')
@section('content')
<div class="content">
    <div class="page-header mb-4">
        <div class="page-title">
            <h4 class="mb-1">Update Barangay ID Template</h4>
            <p class="text-muted">Modify the existing Barangay ID design elements</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0">Edit Template Configuration</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('barangayid.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <!-- Logos Section -->
                    <div class="col-12">
                        <div class="section-header mb-3">
                            <h6 class="section-title text-primary"><i class="fas fa-images me-2"></i> Logos</h6>
                            <p class="text-muted small">Update the official logos for the ID card</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Current Primary Logo</label>
                            <div class="current-file-container mb-3">
                                <img src="{{ asset('storage/'.$item->logo1_path) }}" class="img-thumbnail" style="max-height: 120px;">
                            </div>
                            <div class="file-upload-container">
                                <label class="form-label fw-semibold">Update Logo 1</label>
                                <input type="file" name="logo1" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Leave blank to keep current logo</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Current Secondary Logo</label>
                            <div class="current-file-container mb-3">
                                <img src="{{ asset('storage/'.$item->logo2_path) }}" class="img-thumbnail" style="max-height: 120px;">
                            </div>
                            <div class="file-upload-container">
                                <label class="form-label fw-semibold">Update Logo 2</label>
                                <input type="file" name="logo2" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Leave blank to keep current logo</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Headings Section -->
                    <div class="col-12 mt-4">
                        <div class="section-header mb-3">
                            <h6 class="section-title text-primary"><i class="fas fa-heading me-2"></i> Headings</h6>
                            <p class="text-muted small">Modify the text elements for the ID card</p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Heading 1</label>
                            <input type="text" name="heading1" class="form-control" value="{{ $item->heading1 }}" required>
                            <small class="form-text text-muted">Main heading text</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Heading 2</label>
                            <input type="text" name="heading2" class="form-control" value="{{ $item->heading2 }}" required>
                            <small class="form-text text-muted">Secondary heading text</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Heading 3</label>
                            <input type="text" name="heading3" class="form-control" value="{{ $item->heading3 }}" required>
                            <small class="form-text text-muted">Tertiary heading text</small>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Validity Period</label>
                            <input type="text" name="validity" class="form-control" value="{{ $item->validity }}" required>
                            <small class="form-text text-muted">ID card expiration duration</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Barangay Captain Name</label>
                            <input type="text" name="pass_captain" class="form-control" value="{{ $item->pass_captain }}" required>
                            <small class="form-text text-muted">Full name of the Barangay Captain</small>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Additional Details</label>
                            <textarea name="details" class="form-control" rows="3" required>{{ $item->details }}</textarea>
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
                            <label class="form-label fw-semibold">Current Signature</label>
                            <div class="current-file-container mb-3">
                                <img src="{{ asset('storage/'.$item->signature_path) }}" class="img-thumbnail" style="max-height: 80px;">
                            </div>
                            <div class="file-upload-container">
                                <label class="form-label fw-semibold">Update Signature</label>
                                <input type="file" name="signature" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Leave blank to keep current signature</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-end border-top pt-4">
                              <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i> Update Template
                            </button><br>

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
    
    .current-file-container {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 0.375rem;
        text-align: center;
    }
    
    .card {
        border-radius: 0.5rem;
    }
    
    .form-label {
        margin-bottom: 0.5rem;
    }
    
    .img-thumbnail {
        background-color: #fff;
        border: 1px solid #dee2e6;
    }
</style>
@endsection