<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=794px">
    <title>Barangay Death Certificate - {{ $deathCertificate->resident->full_name }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            font-size: 14px;
            line-height: 1.5;
            background: #fff;
        }
        .container {
            width: 794px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            position: relative;
        }
        .header-content {
            position: relative;
            padding: 0 90px;
        }
        .header h1 {
            font-size: 16px;
            margin: 5px 0;
            font-weight: bold;
            line-height: 1.3;
        }
        .header p {
            margin: 3px 0;
            font-size: 13px;
        }
        .logo-left,
        .logo-right {
            position: absolute;
            top: 30px;
            width: 70px;
            height: 70px;
            object-fit: contain;
            transform: translateY(-50%);
        }
        .logo-left { left: 90px; }
        .logo-right { right: 90px; }
        .official { margin-bottom: 6px; }
        .certificate-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            text-decoration: underline;
        }
        .content {
            margin: 1px 0;
            font-size: 13px;
        }
        .content p { margin: 8px 0; }
        .signature {
            margin-top: 80px;
            text-align: right;
            padding-right: 100px;
            font-size: 15px;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin-left: auto;
            margin-bottom: 5px;
        }
        .signature-name {
            font-weight: bold;
            text-transform: uppercase;
        }
        .signature-title {
            margin-top: -5px;
            font-style: italic;
        }
        .divider {
            border-top: 1px solid #000;
            margin: 10px 0;
        }
        .underline { text-decoration: underline; }
        @media print {
            body, html {
                width: 800px;
                height: 950px;
                margin: 0 auto;
                padding: 0;
            }
            .container { page-break-inside: avoid; }
            img { max-width: 100%; height: auto; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header" style="margin-bottom: 10px; padding-bottom: 5px;">
            <div class="header-content" style="padding: 0 70px;">
                @if($barangayDetails)
                    @if($barangayDetails->logo1_path)
                        <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" class="logo-left" alt="Left Logo">
                    @endif
                    @if($barangayDetails->logo2_path)
                        <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" class="logo-right" alt="Right Logo">
                    @endif
                @endif
                <h1>REPUBLIC OF THE PHILIPPINES</h1>
                <h1>PROVINCE OF NEGROS OCCIDENTAL</h1>
                <h1>MUNICIPALITY OF HINOBA-AN</h1>
            </div>
        </div>

        <div style="text-align: center; margin-bottom: 20px;">
            <h3>OFFICE OF THE PUNONG BARANGAY</h3>
        </div>

        <div class="divider"></div>

        <div class="certificate-title">BARANGAY DEATH CERTIFICATE</div>

        <div class="content" style="text-align: justify;">
            <h4 style="text-align: left; font-style: italic; margin-bottom: 20px;">TO WHOM IT MAY CONCERN:</h4>
            
            <p style="text-indent: 0.5in; margin-bottom: 15px;">
                This is to certify that, <strong><u>{{ strtoupper($deathCertificate->resident->first_name.' '.$deathCertificate->resident->middle_name.' '.$deathCertificate->resident->last_name) }}</u></strong>, 
                <strong>{{ strtolower($deathCertificate->civil_status_at_death) }}</strong>, 
                <strong><u>{{ \Carbon\Carbon::parse($deathCertificate->birth_date)->age }}</u></strong> years old and a resident of 
                <strong>Purok-{{ $deathCertificate->purok ?? 'N/A' }}</strong>, Barangay II-Poblacion, Hinoba-an, Negros Occidental, 
                died on <strong><u>{{ strtoupper($deathCertificate->date_of_death->format('F j, Y')) }}, {{ $deathCertificate->time_of_death ? date('h:i A', strtotime($deathCertificate->time_of_death)) : 'N/A' }}</u></strong> 
                at their residence.
            </p>
            
            <p style="text-indent: 0.5in; margin-bottom: 15px;">
                This certification is issued for whatever legal purpose it may serve best.
            </p>
            
            <p style="text-indent: 0.5in; margin-bottom: 15px;">
                Signed and given this <strong>{{ $deathCertificate->date_of_issuance->format('jS') }}</strong> day of 
                <strong>{{ $deathCertificate->date_of_issuance->format('F, Y') }}</strong> at the Office of the Punong Barangay of 
                Barangay II-Poblacion, Hinoba-an, Negros Occidental, Philippines.
            </p>
        </div>

        <div class="signature">
            @php
                
                $captain = $officials->first(function($official) {
                    return stripos($official->position->name, 'Punong') !== false || 
                           stripos($official->position->name, 'Captain') !== false;
                });
            @endphp
            
            @if($captain)
                <div class="signature-line"></div>
                <div class="signature-name">{{ strtoupper($captain->name) }}</div>
                <div class="signature-title">Punong Barangay</div>
            @else
                <div class="signature-line"></div>
                <div class="signature-name">[PUNONG BARANGAY NAME]</div>
                <div class="signature-title">Punong Barangay</div>
            @endif
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>