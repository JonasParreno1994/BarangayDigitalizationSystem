<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="form-label">Resident</label>
            <div class="form-input bg-gray-100">{{ $deathCertificate->resident->last_name }}, {{ $deathCertificate->resident->first_name }} {{ $deathCertificate->resident->middle_name }}</div>
        </div>
        <div>
            <label class="form-label">Civil Status at Death</label>
            <div class="form-input bg-gray-100">{{ $deathCertificate->civil_status_at_death }}</div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="form-label">Date of Death</label>
            <div class="form-input bg-gray-100">{{ $deathCertificate->date_of_death->format('F j, Y') }}</div>
        </div>
        <div>
            <label class="form-label">Time of Death</label>
            <div class="form-input bg-gray-100">{{ $deathCertificate->time_of_death ? date('h:i A', strtotime($deathCertificate->time_of_death)) : 'N/A' }}</div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="form-label">Place of Death</label>
            <div class="form-input bg-gray-100">{{ $deathCertificate->place_of_death }}</div>
        </div>
        <div>
            <label class="form-label">Cause of Death</label>
            <div class="form-input bg-gray-100">{{ $deathCertificate->cause_of_death }}</div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="form-label">Purok</label>
            <div class="form-input bg-gray-100">{{ $deathCertificate->purok ?? 'N/A' }}</div>
        </div>
        <div>
            <label class="form-label">Date of Issuance</label>
            <div class="form-input bg-gray-100">{{ $deathCertificate->date_of_issuance->format('F j, Y') }}</div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="form-label">Status</label>
            <div class="form-input bg-gray-100">
                <span class="badge {{ $deathCertificate->status == 'Issued' ? 'bg-success' : ($deathCertificate->status == 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                    {{ $deathCertificate->status }}
                </span>
            </div>
        </div>
    </div>
    
    <div>
        <label class="form-label">Remarks</label>
        <div class="form-input bg-gray-100 min-h-[100px]">{{ $deathCertificate->remarks ?? 'N/A' }}</div>
    </div>
    
    <div class="flex justify-end space-x-3 mt-6">
        <button type="button" onclick="closeViewModal()" class="btn btn-outline-danger">Close</button>
        <a href="{{ route('death-certificate.print', $deathCertificate->id) }}" target="_blank" class="btn btn-success">Print Certificate</a>
    </div>
</div>