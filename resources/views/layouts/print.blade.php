<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=794px">
    <title>@yield('page_title', 'Certificate')</title>
    <style>
        @page { size: A4; margin: 12mm; }
        body { font-family: 'Times New Roman', Times, serif; margin:0; padding:0; background:#fafafa; color:#000 }
        .page { width:210mm; margin:0 auto; padding:20mm 18mm; box-sizing:border-box; background:#fff; border-radius:.375rem; box-shadow:0 1px 3px rgba(0,0,0,0.1) }
        .header { position:relative; text-align:center; padding-bottom:1px; }
        .logo-left { position:absolute; left:18mm; top:.05mm; width:100px; height:100px; object-fit:contain }
        .logo-right { position:absolute; right:18mm; top:.05mm; width:90px; height:90px; object-fit:contain }
        .header .gov { font-weight:700;font-family: Calisto MT; font-size:13px; margin:2px 0 }
        .header .barangay { font-weight:900; font-size:20px; margin:4px 0; color:#0b5ed7 }
        .office { font-weight:700; font-style:italic; font-size:14px; color:#0b5ed7 }
        .title { text-align:center; font-size:26px; font-weight:700; margin:18px 0 8px }
        .to-whom { font-style:italic; margin-bottom:6px }
        .content { font-size:20px;font-family: 'Times New Roman', Times, serif; text-align:justify; margin:6px 0; line-height:2 }
        .content p { text-indent:0.6in; margin:10px 0 }
        .signature-row { display:flex; justify-content:space-between; align-items:flex-end; margin-top:50px }
        .applicant { width:45%; text-align:left }
        .applicant .name { font-weight:700; text-decoration:underline }
        .sign { width:45%; text-align:center }
        .sign .name { font-weight:700; text-decoration:underline; display:block }
        .sign .position { margin-top:4px; font-size:14px }
        .footer { margin-top:40px; font-size:12px }
        .receipt { margin-top:18px }
        .contact { margin-top:24px; font-size:12px; border-top:2px solid #e6e6e6; padding-top:8px; display:flex; justify-content:space-between; align-items:center }
        .contact .left { font-size:12px }
        .contact .right { font-size:12px }
        @media print {
            body, html { width:210mm }
            .page { padding:12mm }
            .navbar, .topbar, .breadcrumb, .print-header, .no-print { display:none !important; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header" style="text-align:center; padding-left:0">
            @if(isset($barangayDetails) && $barangayDetails->logo1_path)
                <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" class="logo-left" alt="logo left">
            @endif
            @if(isset($barangayDetails) && $barangayDetails->logo2_path)
                <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" class="logo-right" alt="logo right">
            @endif
            <div class="gov">REPUBLIC OF THE PHILIPPINES</div>
            <div class="gov">PROVINCE OF {{ strtoupper($barangayDetails->province ?? '') }}</div>
            <div class="gov">MUNICIPALITY OF {{ strtoupper($barangayDetails->city_municipality ?? $barangayDetails->municipality ?? '') }}</div>
            <div class="barangay">BARANGAY {{ strtoupper($barangayDetails->barangay_name ?? $barangayDetails->barangay ?? $barangayDetails->name ?? '') }}</div>
            <div class="office">Office of the Punong Barangay</div>
            <div style="margin-top:12px">
                <hr style="border:none; border-top:2px solid #000; margin:6px auto; width:100%">
                <hr style="border:none; border-top:1px solid #000; margin:0 auto; width:100%">
            </div>
        </div>

        {{-- title area; child templates should provide their own title markup --}}
        @yield('title')

        {{-- main content area; child templates provide content --}}
        @yield('content')

        {{-- contact/footer area provided by child if needed --}}
        @yield('contact')
    </div>

    {{-- allow child templates to include print scripts and other inline JS --}}
    @yield('scripts')
</body>
</html>
