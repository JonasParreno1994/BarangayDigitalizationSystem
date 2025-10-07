@extends('layouts.adminLayout.index')
@section('content')
<div class="content">
    <div class="page-header mb-4">
        <div class="page-title">
            <h4 class="mb-1">Update Barangay ID Template</h4>
            <p class="text-muted">Modify the enhanced Barangay ID design elements and content</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0">Edit Enhanced Template Configuration</h5>
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
                            <p class="text-muted small">Configure the text elements for the ID card</p>
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
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Office Information</label>
                            <input type="text" name="office_info" class="form-control" value="{{ $item->office_info ?? 'Office of the Punong Barangay' }}">
                            <small class="form-text text-muted">Office designation text</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Ordinance Information</label>
                            <input type="text" name="ordinance_info" class="form-control" value="{{ $item->ordinance_info ?? 'Brgy. Ord. 001 S. of 2021 | SB Res. 2021-202' }}">
                            <small class="form-text text-muted">Ordinance reference</small>
                        </div>
                    </div>
                    
                    <!-- Card Details Section -->
                    <div class="col-12 mt-4">
                        <div class="section-header mb-3">
                            <h6 class="section-title text-primary"><i class="fas fa-info-circle me-2"></i> Card Details</h6>
                            <p class="text-muted small">Configure validity and identification details</p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Validity Period</label>
                            <input type="text" name="validity" class="form-control" value="{{ $item->validity }}" required>
                            <small class="form-text text-muted">ID card expiration duration</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Validity Years</label>
                            <select name="validity_years" class="form-control">
                                <option value="1" {{ ($item->validity_years ?? 3) == 1 ? 'selected' : '' }}>1 Year</option>
                                <option value="2" {{ ($item->validity_years ?? 3) == 2 ? 'selected' : '' }}>2 Years</option>
                                <option value="3" {{ ($item->validity_years ?? 3) == 3 ? 'selected' : '' }}>3 Years</option>
                                <option value="4" {{ ($item->validity_years ?? 3) == 4 ? 'selected' : '' }}>4 Years</option>
                                <option value="5" {{ ($item->validity_years ?? 3) == 5 ? 'selected' : '' }}>5 Years</option>
                            </select>
                            <small class="form-text text-muted">Numeric validity for calculations</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Barangay Captain Name</label>
                            <input type="text" name="pass_captain" class="form-control" value="{{ $item->pass_captain }}" required>
                            <small class="form-text text-muted">Full name of the Barangay Captain</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Footer Text</label>
                            <input type="text" name="footer_text" class="form-control" value="{{ $item->footer_text ?? 'ISSUED BASED UPON INFORMATION FURNISHED BY APPLICANT.' }}">
                            <small class="form-text text-muted">Front card footer text</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Card Title</label>
                            <input type="text" name="card_title" class="form-control" value="{{ $item->card_title ?? 'BARANGAY IDENTIFICATION CARD' }}">
                            <small class="form-text text-muted">Main ID card title</small>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Additional Details</label>
                            <textarea name="details" class="form-control" rows="3" required>{{ $item->details }}</textarea>
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
                            <input type="text" name="back_header" class="form-control" value="{{ $item->back_header ?? 'THIS CARD IS NON-TRANSFERABLE' }}">
                            <small class="form-text text-muted">Header text for back side</small>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Certification Text</label>
                            <textarea name="back_certification" class="form-control" rows="3">{{ $item->back_certification ?? 'This certifies that the person whose name and picture appear on the reverse side of this card is a bonafide resident of BARANGAY BACUYANGAN, MUNICIPALITY OF HINOBA-AN, NEGROS OCCIDENTAL.' }}</textarea>
                            <small class="form-text text-muted">Certification statement</small>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Validity Note</label>
                            <textarea name="back_note" class="form-control" rows="3">{{ $item->back_note ?? "NOTE: This card is valid only if SIGNED by the PUNONG BARANGAY.\n\nLoss of this card must be reported immediately to the Barangay Hall." }}</textarea>
                            <small class="form-text text-muted">Important notes and conditions</small>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Additional Information</label>
                            <input type="text" name="back_loss_info" class="form-control" value="{{ $item->back_loss_info ?? 'Issued based upon information furnished by the applicant.' }}">
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
                            <input type="text" name="emergency_contact_name" class="form-control" value="{{ $item->emergency_contact_name ?? 'ROSA NARCISO' }}">
                            <small class="form-text text-muted">Emergency contact person</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Contact Number</label>
                            <input type="text" name="emergency_contact_number" class="form-control" value="{{ $item->emergency_contact_number ?? '09530538077' }}">
                            <small class="form-text text-muted">Emergency contact phone</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Contact Address</label>
                            <input type="text" name="emergency_contact_address" class="form-control" value="{{ $item->emergency_contact_address ?? 'ZONE 3, BRGY. BACUYANGAN, HINOBA-AN NEG. OCC.' }}">
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
                                <option value="blue" {{ ($item->card_color_scheme ?? 'blue') == 'blue' ? 'selected' : '' }}>Blue</option>
                                <option value="green" {{ ($item->card_color_scheme ?? 'blue') == 'green' ? 'selected' : '' }}>Green</option>
                                <option value="red" {{ ($item->card_color_scheme ?? 'blue') == 'red' ? 'selected' : '' }}>Red</option>
                                <option value="purple" {{ ($item->card_color_scheme ?? 'blue') == 'purple' ? 'selected' : '' }}>Purple</option>
                            </select>
                            <small class="form-text text-muted">Card color theme</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="include_fingerprint" class="form-check-input" {{ ($item->include_fingerprint ?? true) ? 'checked' : '' }} id="fingerprint">
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
                                <input type="checkbox" name="include_qr_code" class="form-check-input" {{ ($item->include_qr_code ?? true) ? 'checked' : '' }} id="qrcode">
                                <label class="form-check-label fw-semibold" for="qrcode">
                                    Include QR Code
                                </label>
                            </div>
                            <small class="form-text text-muted">Generate QR code for ID</small>
                        </div>
                    </div>
                    
                    <!-- Signature Section -->
                    <div class="col-12 mt-4">
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
                                <label class="form-label fw-semibold">Update Signature Image</label>
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
    
    .current-file-container {
        text-align: center;
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
    }
    
    .card {
        border-radius: 0.5rem;
    }
    
    .form-label {
        margin-bottom: 0.5rem;
    }
</style>
@endsection