{{-- Barangay Header Component for Print Forms --}}
<div class="barangay-header" style="text-align: center; margin-bottom: 20px;">
    <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
        {{-- Left Logo --}}
        @if(isset($barangayDetails) && ($barangayDetails->logo1_path ?? false))
        <div style="flex: 0 0 80px; margin-right: 20px;">
            <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" 
                 alt="Logo 1" 
                 style="width: 80px; height: 80px; object-fit: contain;">
        </div>
        @endif

        {{-- Center Text --}}
        <div style="flex: 1; text-align: center;">
            <h1 style="margin: 0; font-size: 16px; font-weight: bold; line-height: 1.2;">
                {{ $barangayDetails->heading1 ?? 'REPUBLIC OF THE PHILIPPINES' }}
            </h1>
            <h2 style="margin: 2px 0; font-size: 14px; font-weight: bold; line-height: 1.2;">
                {{ $barangayDetails->heading2 ?? ($barangayDetails->province ?? 'NEGROS OCCIDENTAL') . ', ' . ($barangayDetails->city_municipality ?? 'HINOBA-AN') }}
            </h2>
            <h3 style="margin: 2px 0; font-size: 14px; font-weight: bold; line-height: 1.2;">
                {{ $barangayDetails->heading3 ?? 'BARANGAY ' . ($barangayDetails->barangay_name ?? 'BACUYANGAN') }}
            </h3>
        </div>

        {{-- Right Logo --}}
        @if(isset($barangayDetails) && ($barangayDetails->logo2_path ?? false))
        <div style="flex: 0 0 80px; margin-left: 20px;">
            <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" 
                 alt="Logo 2" 
                 style="width: 80px; height: 80px; object-fit: contain;">
        </div>
        @endif
    </div>
</div>
