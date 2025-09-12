{{-- Barangay Footer Component for Print Forms --}}
<div class="barangay-footer" style="margin-top: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: end;">
        {{-- Left side - Contact Information --}}
        <div style="text-align: left; font-size: 10px; color: #666;">
            @if(isset($barangayDetails) && $barangayDetails->barangay_contact)
                <div>BARANGAY HALL: {{ $barangayDetails->barangay_contact }}</div>
            @endif
            @if(isset($barangayDetails) && $barangayDetails->emergency_contact)
                <div>EMERGENCY: {{ $barangayDetails->emergency_contact }}</div>
            @endif
            @if(isset($barangayDetails) && $barangayDetails->barangay_email)
                <div>EMAIL: {{ $barangayDetails->barangay_email }}</div>
            @endif
        </div>

        {{-- Right side - Official Signature --}}
        <div style="text-align: center; margin-left: 20px;">
            @if(isset($barangayDetails) && $barangayDetails->captain_signature_path)
                <div style="margin-bottom: 5px;">
                    <img src="{{ asset('storage/' . $barangayDetails->captain_signature_path) }}" 
                         alt="Captain Signature" 
                         style="max-height: 40px; max-width: 150px;">
                </div>
            @endif
            <div style="border-top: 1px solid #000; padding-top: 2px; font-weight: bold; font-size: 12px;">
                {{ $barangayDetails->captain_name ?? 'BARANGAY CAPTAIN' }}
            </div>
            <div style="font-size: 10px;">
                {{ $barangayDetails->captain_title ?? 'Punong Barangay' }}
            </div>
        </div>
    </div>

    {{-- Document Footer --}}
    @if(isset($barangayDetails) && $barangayDetails->document_footer)
        <div style="text-align: center; margin-top: 20px; font-size: 10px; font-style: italic; color: #666;">
            {{ $barangayDetails->document_footer }}
        </div>
    @endif
</div>
