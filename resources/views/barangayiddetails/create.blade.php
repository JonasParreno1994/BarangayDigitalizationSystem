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
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Validation Error:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Office Information</label>
                            <input type="text" name="office_info" class="form-control" value="Office of the Punong Barangay">
                            <small class="form-text text-muted">Office designation text</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Ordinance Information</label>
                            <input type="text" name="ordinance_info" class="form-control" value="Brgy. Ord. 001 S. of 2021 | SB Res. 2021-202">
                            <small class="form-text text-muted">Ordinance reference</small>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <div class="col-12 mt-4">
                        <div class="section-header mb-3">
                            <h6 class="section-title text-primary"><i class="fas fa-info-circle me-2"></i> Card Details</h6>
                            <p class="text-muted small">Configure validity and identification details</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Validity Period</label>
                            <input type="text" name="validity" class="form-control" placeholder="e.g. 1 year" required>
                            <small class="form-text text-muted">ID card expiration duration</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Validity Years</label>
                            <select name="validity_years" class="form-control">
                                <option value="1">1 Year</option>
                                <option value="2">2 Years</option>
                                <option value="3" selected>3 Years</option>
                                <option value="4">4 Years</option>
                                <option value="5">5 Years</option>
                            </select>
                            <small class="form-text text-muted">Numeric validity for calculations</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Barangay Captain Name</label>
                            <input type="text" name="pass_captain" class="form-control" placeholder="e.g. Juan Dela Cruz" required>
                            <small class="form-text text-muted">Full name of the Barangay Captain</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Footer Text</label>
                            <input type="text" name="footer_text" class="form-control" value="ISSUED BASED UPON INFORMATION FURNISHED BY APPLICANT.">
                            <small class="form-text text-muted">Front card footer text</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Card Title</label>
                            <input type="text" name="card_title" class="form-control" value="BARANGAY IDENTIFICATION CARD">
                            <small class="form-text text-muted">Main ID card title</small>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Additional Details</label>
                            <textarea name="details" class="form-control" rows="3" placeholder="Enter any additional terms, conditions, or information to be displayed on the ID..." required></textarea>
                            <small class="form-text text-muted">This text will appear on the back of the ID card</small>
                        </div>
                    </div>
                    
                    <!-- Back Side Configuration -->
                    <div class="col-12 mt-4">
                        <div class="section-header mb-3">
                            <h6 class="section-title text-primary"><i class="fas fa-id-card me-2"></i> Back Side Configuration</h6>
                            <p class="text-muted small">Configure the back side content of the ID card</p>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Back Header</label>
                            <input type="text" name="back_header" class="form-control" value="THIS CARD IS NON-TRANSFERABLE">
                            <small class="form-text text-muted">Header text for back side</small>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Certification Text</label>
                            <textarea name="back_certification" class="form-control" rows="3">This certifies that the person whose name and picture appear on the reverse side of this card is a bonafide resident of BARANGAY BACUYANGAN, MUNICIPALITY OF HINOBA-AN, NEGROS OCCIDENTAL.</textarea>
                            <small class="form-text text-muted">Certification statement</small>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Validity Note</label>
                            <textarea name="back_note" class="form-control" rows="3">NOTE: This card is valid only if SIGNED by the PUNONG BARANGAY.

Loss of this card must be reported immediately to the Barangay Hall.</textarea>
                            <small class="form-text text-muted">Important notes and conditions</small>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Additional Information</label>
                            <input type="text" name="back_loss_info" class="form-control" value="Issued based upon information furnished by the applicant.">
                            <small class="form-text text-muted">Additional back side information</small>
                        </div>
                    </div>
                    
                    <!-- Emergency Contact Section -->
                    <div class="col-12 mt-4">
                        <div class="section-header mb-3">
                            <h6 class="section-title text-primary"><i class="fas fa-phone me-2"></i> Emergency Contact</h6>
                            <p class="text-muted small">Emergency contact information for the back of the ID</p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Contact Name</label>
                            <input type="text" name="emergency_contact_name" class="form-control" value="ROSA NARCISO">
                            <small class="form-text text-muted">Emergency contact person</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Contact Number</label>
                            <input type="text" name="emergency_contact_number" class="form-control" value="09530538077">
                            <small class="form-text text-muted">Emergency contact phone</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Contact Address</label>
                            <input type="text" name="emergency_contact_address" class="form-control" value="ZONE 3, BRGY. BACUYANGAN, HINOBA-AN NEG. OCC.">
                            <small class="form-text text-muted">Emergency contact address</small>
                        </div>
                    </div>
                    
                    <!-- Card Customization -->
                    <div class="col-12 mt-4">
                        <div class="section-header mb-3">
                            <h6 class="section-title text-primary"><i class="fas fa-palette me-2"></i> Card Customization</h6>
                            <p class="text-muted small">Customize the appearance and features of the ID card</p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Color Scheme</label>
                            <select name="card_color_scheme" class="form-control">
                                <option value="blue" selected>Blue</option>
                                <option value="green">Green</option>
                                <option value="red">Red</option>
                                <option value="purple">Purple</option>
                            </select>
                            <small class="form-text text-muted">Card color theme</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="include_fingerprint" class="form-check-input" checked value="1" id="fingerprint">
                                <label class="form-check-label fw-semibold" for="fingerprint">
                                    Include Fingerprint Section
                                </label>
                            </div>
                            <small class="form-text text-muted">Show fingerprint area on back</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="include_qr_code" class="form-check-input" checked value="1" id="qrcode">
                                <label class="form-check-label fw-semibold" for="qrcode">
                                    Include QR Code
                                </label>
                            </div>
                            <small class="form-text text-muted">Generate QR code for ID</small>
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
                            </button>
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