<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=794px">
    <title>Barangay Certificate - {{ $certificate->resident->first_name }} {{ $certificate->resident->last_name }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.4;
            background: #fff;
        }
        .container {
            width: 794px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
            position: relative;
        }
        
        /* Left sidebar with officials */
        .officials-sidebar {
            position: absolute;
            left: 20px;
            top: 80px;
            width: 140px;
            font-size: 11px;
            padding-right: 10px;
        }
        
        .official-item {
            margin-bottom: 14px;
            text-align: center;
            line-height: 1.1;
        }
        
        .official-name {
            font-weight: bold;
            font-size: 11px;
            line-height: 1.2;
            color: #000;
            margin-bottom: 1px;
        }
        
        .official-position {
            font-size: 9px;
            color: #000;
            font-weight: normal;
            margin-top: 1px;
            line-height: 1.1;
        }
        
        /* Main content area */
        .main-content {
            margin-left: 180px;
            padding: 0 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            padding-top: 10px;
        }
        
        .header-text {
            font-size: 11px;
            line-height: 1.3;
            margin: 2px 0;
        }
        
        .logo-left,
        .logo-right {
            position: absolute;
            width: 60px;
            height: 60px;
            object-fit: contain;
            top: 10px;
        }
        
        .logo-left { left: -30px; }
        .logo-right { right: -30px; }
        
        .certificate-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            text-decoration: underline;
        }
        
        .to-whom {
            text-align: center;
            font-weight: bold;
            margin: 15px 0;
            font-size: 12px;
        }
        
        .certificate-body {
            text-align: justify;
            font-size: 12px;
            line-height: 1.6;
            margin: 20px 0;
            text-indent: 50px;
        }
        
        .resident-info {
            font-weight: bold;
            text-decoration: underline;
        }
        
        .signature-section {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
        }
        
        .signature-line {
            margin-top: 30px;
            border-bottom: 1px solid #000;
            width: 200px;
            margin-left: auto;
        }
        
        .signature-name {
            font-weight: bold;
            margin-top: 5px;
        }
        
        .signature-title {
            font-style: italic;
            font-size: 10px;
        }
        
        .footer-info {
            margin-top: 40px;
            font-size: 10px;
        }
        
        .payment-info {
            margin-top: 20px;
            font-size: 11px;
        }
        
        .background-image {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            width: 300px;
            height: 150px;
            opacity: 0.1;
            z-index: -1;
        }
        
        @media print {
            body, html {
                width: 800px;
                height: 950px;
                margin: 0;
                padding: 0;
            }
            .container { 
                page-break-inside: avoid;
                width: 100%;
                margin: 0;
                padding: 20px;
            }
            img { max-width: 100%; height: auto; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Officials Sidebar -->
        <div class="officials-sidebar">
            @if($officials && $officials->count() > 0)
                @foreach($officials->take(14) as $official)
                    <div class="official-item">
                        <div class="official-name">{{ strtoupper($official->name ?? 'N/A') }}</div>
                        <div class="official-position">{{ strtoupper($official->position->position ?? $official->committee ?? 'BARANGAY KAGAWAD') }}</div>
                    </div>
                @endforeach
            @else
                <div class="official-item">
                    <div class="official-name">NO OFFICIALS</div>
                    <div class="official-position">AVAILABLE</div>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                @if(isset($barangayDetails) && $barangayDetails->logo1_path)
                    <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" alt="Logo 1" class="logo-left">
                @endif
                @if(isset($barangayDetails) && $barangayDetails->logo2_path)
                    <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" alt="Logo 2" class="logo-right">
                @endif
                
                <div class="header-text">Republic of the Philippines</div>
                <div class="header-text">Province of {{ $barangayDetails->province ?? 'Negros Occidental' }}</div>
                <div class="header-text">Municipality of {{ $barangayDetails->municipality ?? 'Hinobaan' }}</div>
                <div class="header-text"><strong>{{ strtoupper($barangayDetails->barangay_name ?? 'BARANGAY BACUYANGAN') }}</strong></div>
                <div class="header-text">Office of the Punong Barangay</div>
            </div>

            <!-- Certificate Title -->
            <div class="certificate-title">BARANGAY CERTIFICATE</div>

            <!-- To Whom It May Concern -->
            <div class="to-whom">TO WHOM IT MAY CONCERN:</div>

            <!-- Certificate Body -->
            <div class="certificate-body">
                This is to certify that 
                <span class="resident-info">
                    {{ strtoupper($certificate->resident->first_name . ' ' . ($certificate->resident->middle_name ? $certificate->resident->middle_name[0] . '. ' : '') . $certificate->resident->last_name) }}, 
                    {{ \Carbon\Carbon::parse($certificate->resident->birth_date)->age }} years old, 
                    {{ strtolower($certificate->resident->civil_status) }}, is a Filipino Citizen, 
                    {{ strtolower($certificate->resident->civil_status === 'Married' ? 
                        ($certificate->resident->sex === 'Male' ? 'married' : 'married') : 'separated') }}.
                </span>
                is a bonafide resident of {{ $barangayDetails->barangay_name ?? 'Barangay Bacuyangan' }}, {{ $barangayDetails->municipality ?? 'Hinobaan' }}, {{ $barangayDetails->province ?? 'Negros Occidental' }}.
            </div>

            <div class="certificate-body" style="text-indent: 50px; margin-top: 15px;">
                He/She has established residence in {{ $barangayDetails->barangay_name ?? 'Barangay Bacuyangan' }}, {{ $barangayDetails->municipality ?? 'Hinobaan' }}, {{ $barangayDetails->province ?? 'Negros Occidental' }} for a period of 
                @if($certificate->residence_period_years || $certificate->residence_period_months)
                    {{ $certificate->residence_period_years ? $certificate->residence_period_years . ' year' . ($certificate->residence_period_years > 1 ? 's' : '') : '' }}
                    {{ $certificate->residence_period_years && $certificate->residence_period_months ? ' and ' : '' }}
                    {{ $certificate->residence_period_months ? $certificate->residence_period_months . ' month' . ($certificate->residence_period_months > 1 ? 's' : '') : '' }}
                @else
                    _____ years now,
                @endif
                and is known to me to be a person of good moral character.
            </div>

            <div class="certificate-body" style="text-indent: 50px; margin-top: 15px;">
                He has not been engaged in <strong>any unlawful activity as per Barangay file.</strong>
            </div>

            <div class="certificate-body" style="text-indent: 50px; margin-top: 15px;">
                This certification is issued upon the request of the interested party and whatever legal purpose it may serve him/her best.
            </div>

            <div class="certificate-body" style="text-indent: 50px; margin-top: 15px;">
                Issued and signed this 
                <strong>{{ \Carbon\Carbon::parse($certificate->date_of_issuance)->format('jS') }}</strong> 
                day of 
                <strong>{{ \Carbon\Carbon::parse($certificate->date_of_issuance)->format('F, Y') }}</strong> 
                at {{ $barangayDetails->barangay_name ?? 'Barangay Bacuyangan' }} Administration Center.
            </div>

            <!-- Signature Section -->
            <div class="signature-section">
                <div class="signature-line"></div>
                @php
                    $captain = $officials ? $officials->first(fn($official) => 
                        stripos($official->position->position ?? '', 'punong') !== false || 
                        stripos($official->committee ?? '', 'punong') !== false
                    ) : null;
                @endphp
                <div class="signature-name">{{ strtoupper($captain->name ?? $barangayDetails->punong_barangay_name ?? 'PUNONG BARANGAY') }}</div>
                <div class="signature-title">Punong Barangay</div>
            </div>

            <!-- Payment Information -->
            @if($certificate->or_number || $certificate->amount_paid)
            <div class="payment-info">
                @if($certificate->or_number)
                    <div><strong>{{ strtoupper($certificate->resident->first_name . ' ' . ($certificate->resident->middle_name ? $certificate->resident->middle_name[0] . '. ' : '') . $certificate->resident->last_name) }}</strong></div>
                    <div>Paid under Receipt No: {{ $certificate->or_number }}</div>
                @endif
                @if($certificate->amount_paid)
                    <div>Amount: {{ number_format($certificate->amount_paid, 2) }}</div>
                @endif
                <div>Date: {{ \Carbon\Carbon::parse($certificate->date_of_issuance)->format('m-d-Y') }}</div>
            </div>
            @endif
        </div>

    </div>

    <script>
        window.onload = function() {
            window.print();
        }
        
        window.onafterprint = function() {
            // Try to close if opened in popup, otherwise redirect with success message
            if (window.opener) {
                window.close();
            } else {
                window.location.href = "{{ route('barangay-certificate.index') }}?printed=1";
            }
        }
        
        // Fallback: if user closes window/tab without printing
        window.addEventListener('beforeunload', function() {
            // This will only trigger if user manually closes without printing
            if (!window.printed) {
                // This won't work for navigation, but good for manual close
            }
        });
    </script>
</body>
</html>