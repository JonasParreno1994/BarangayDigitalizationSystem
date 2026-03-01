<style>
    .full-width-header {
        margin: 0 -18mm;
    }
    @media print {
        .full-width-header {
            margin: 0 -12mm;
        }
    }
</style>
<div class="header full-width-header" style="text-align:center; padding-left:0; background: linear-gradient(to bottom, #d6f5d6, #ffffff); padding-top: 10px; padding-bottom: 10px; border-radius: 10px 10px 0 0; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
    @if(isset($barangayDetails) && $barangayDetails->logo1_path)
        <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" class="logo-left" style="top: 15px;" alt="logo left">
    @endif
    @if(isset($barangayDetails) && $barangayDetails->logo2_path)
        <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" class="logo-right" style="top: 15px;" alt="logo right">
    @endif
    <div class="gov">REPUBLIC OF THE PHILIPPINES</div>
    <div class="gov">PROVINCE OF {{ strtoupper($barangayDetails->province ?? '') }}</div>
    <div class="gov">MUNICIPALITY OF
        {{ strtoupper($barangayDetails->city_municipality ?? $barangayDetails->municipality ?? '') }}</div>
    <div class="barangay">BARANGAY
        {{ strtoupper($barangayDetails->barangay_name ?? $barangayDetails->barangay ?? $barangayDetails->name ?? '') }}
    </div>
    <div class="office">Office of the Punong Barangay</div>
    <div style="margin-top:12px">
        <hr style="border:none; border-top:2px solid #000; margin:6px auto; width:100%">
        <hr style="border:none; border-top:1px solid #000; margin:0 auto; width:100%">
    </div>
</div>
