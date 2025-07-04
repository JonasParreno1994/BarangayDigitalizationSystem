<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=794px">
    <title>Barangay Clearance - {{ $clearance->resident->full_name }}</title>
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
        .logo-left { left: 120px; }
        .logo-right { right: 120px; }
        .official { margin-bottom: 6px; }
        .clearance-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
        }
        .content {
            margin: 15px 0;
            font-size: 13px;
            line-height: 1.5;
        }
        .content p { margin: 8px 0; }
        .signature {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .signature-title {
            margin-top: -8px;
            font-style: italic;
        }
        .footer {
            margin-top: 20px;
            font-size: 11px;
            text-align: center;
            line-height: 1.3;
        }
        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 4px;
            position: relative;
            top: 2px;
        }
        .checked { background-color: #000; }
        .underline { text-decoration: underline; }
        @media print {
            body, html {
                width: 794px;
                height: 1123px;
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
        <div style="display: none;">
            <h3>Debug Information:</h3>
            <h4>All Officials:</h4>
            <ul>
                @foreach($officials as $official)
                    <li>
                        {{ $official->name }} - 
                        {{ $official->position->name }} - 
                        Committee: {{ $official->committee ?? 'None' }} - 
                        Status: {{ $official->status }}
                    </li>
                @endforeach
            </ul>
        </div>

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
                <h1>PROVINCE OF {{ strtoupper($clearance->resident->province) }}</h1>
                <h1>MUNICIPALITY OF {{ strtoupper($clearance->resident->city_municipality) }}</h1>
                <p>{{ strtoupper($clearance->resident->barangay) }}</p>
                <p>E-mail: __________ * Tel/CP No.  __________</p>
            </div>
        </div>

        @php
            $captain = $officials->first(fn($official) =>
                stripos($official->position->name, 'Punong') !== false ||
                stripos($official->position->name, 'Captain') !== false
            );
            $secretary = $officials->first(fn($official) =>
                stripos($official->position->name, 'Secretary') !== false
            );
            $treasurer = $officials->first(fn($official) =>
                stripos($official->position->name, 'Treasurer') !== false
            );
            $kagawads = $officials->reject(fn($official) =>
                $official === $captain || $official === $secretary || $official === $treasurer
            );
        @endphp

        <div class="clearance-title">BARANGAY CLEARANCE</div>
        <br>
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <!-- Left: Officials Column -->
            <div class="official" style="width: 30%; text-align: left;">
                <div class="official">
                    @php
                        $official_pos3 = $officials->first(fn($official) => $official->position_id == 3);
                    @endphp
                    @if($official_pos3)
                        <strong>{{ strtoupper($official_pos3->name) }}</strong><br>
                        @if($official_pos3->committee)
                            <span>{{ $official_pos3->committee }}</span>
                        @endif
                    @endif
                    <br>
                </div>
                <br>
                <div class="official"><strong style="font-size: 12px;">BARANGAY COUNCIL MEMBERS:</strong></div>
                @foreach($kagawads as $kagawad)
                    <div class="official">
                        @if(in_array($kagawad->position_id, [1, 4, 5]))
                            <strong>{{ strtoupper($kagawad->name) }}</strong><br>
                            @if($kagawad->committee)
                                {{ $kagawad->committee }}
                            @endif
                        @endif
                    </div>
                @endforeach
                <br><br><br><br>
                <div style="text-align: left; width: 100%; align-self: flex-start; line-height:5px; font-size: 10px;">
                    <div style="margin-bottom: 6px;">
                        Clearance No.: {{ $clearance->id ?? '__________' }}
                    </div>
                    <div style="margin-bottom: 6px;">
                        <em>(Revised {{ date('F j, Y') }})</em>
                    </div>
                    <div style="margin-bottom: 6px;">
                        OR No.: {{ $clearance->or_number ?? '__________' }} | Amount Paid: {{ $clearance->amount_paid ? '₱' . number_format($clearance->amount_paid, 2) : '__________' }}
                    </div>
                    <div>
                        Cedula No.: {{ $clearance->cedula_number ?? '__________' }} | Date Issued: {{ $clearance->date_of_issuance->format('m/d/Y') }}
                    </div>
                    <div style="margin-top: 8px;">
                        VALID UNTIL {{ $clearance->date_of_issuance->addYear()->format('F j, Y') }}
                    </div>
                </div>
                <br><br><br><br><br><br><br><br>
            </div>
            <div style="width: 2px; margin: 0 10px; align-self: stretch; display: flex;">
                <div style="background: #000; width: 100%; height: 100%;"></div>
            </div>
            <!-- Right: Clearance Content -->
            <div style="width: 58%; display: flex; flex-direction: column; align-items: center; font-size: 15px; font-family: 'Times New Roman', Times, serif;">
                <div class="content" style="text-align: justify; font-size: 15px;">
                    <p>
                        This is to certify that <strong><u>{{ strtoupper($clearance->resident->full_name) }}</u></strong>,
                        {{ \Carbon\Carbon::parse($clearance->resident->birth_date)->age }} years old,
                        {{ strtolower($clearance->resident->civil_status) }},
                        a bonafide resident presently residing at
                        <u>{{ $clearance->resident->address }}, Barangay {{ $clearance->resident->barangay }},
                        {{ $clearance->resident->city_municipality }}</u>.
                    </p>
                    <p>
                        is a law-abiding citizen and has <strong>NO DEROGATORY</strong> record/s in this office up to this date.
                    </p>
                    <p>
                        Given this <u>{{ $clearance->date_of_issuance->format('jS') }}</u> day of 
                        <u>{{ $clearance->date_of_issuance->format('F') }}</u>, 
                        {{ $clearance->date_of_issuance->format('Y') }} at Barangay {{ $clearance->resident->barangay }}, 
                        {{ $clearance->resident->city_municipality }}.
                    </p>
                    <p>
                        Purpose: <u>{{ $clearance->purpose }}</u>
                    </p>
                </div>
                <div class="signature" style="text-align: center; font-size: 17px;">
                    @if($official_pos3)
                        <strong>{{ strtoupper($official_pos3->name) }}</strong><br>
                        @if($official_pos3->committee)
                            <span>{{ $official_pos3->committee }}</span>
                        @endif
                    @endif
                    <br>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
