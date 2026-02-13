<style>
    .cert-header { text-align:center; padding-bottom:6px; border-bottom:2px solid #000; margin-bottom:16px; position:relative }
    .cert-header .gov { font-weight:700; font-size:13px; margin:2px 0 }
    .cert-header .barangay { font-weight:900; font-size:20px; margin:4px 0; color:#0b5ed7 }
    .cert-header .office { font-weight:700; font-style:italic; font-size:14px; color:#0b5ed7 }
    .cert-logo-left, .cert-logo-right { position:absolute; top:6px; width:80px; height:80px; object-fit:contain }
    .cert-logo-left { left:10px }
    .cert-logo-right { right:10px }
    .cert-title { text-align:center; font-size:22px; font-weight:800; margin:12px 0 }
    .cert-sub { text-align:center; font-style:italic; margin-bottom:8px }
    @media print { .no-print { display:none!important } }
</style>

<div class="cert-header">
    @if(isset($barangayDetails) && $barangayDetails->logo1_path)
        <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" class="cert-logo-left" alt="logo left">
    @endif
    @if(isset($barangayDetails) && $barangayDetails->logo2_path)
        <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" class="cert-logo-right" alt="logo right">
    @endif
    <div class="gov">REPUBLIC OF THE PHILIPPINES</div>
    <div class="gov">PROVINCE OF {{ strtoupper($barangayDetails->province ?? '') }}</div>
    <div class="gov">MUNICIPALITY OF {{ strtoupper($barangayDetails->city_municipality ?? $barangayDetails->municipality ?? '') }}</div>
    <div class="barangay">BARANGAY {{ strtoupper($barangayDetails->barangay_name ?? $barangayDetails->barangay ?? $barangayDetails->name ?? '') }}</div>
    <div class="office">Office of the Punong Barangay</div>
</div>
