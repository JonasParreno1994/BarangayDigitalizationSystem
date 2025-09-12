<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=794px">
    <title>Death Certificate - {{ $certificate->resident->last_name }}, {{ $certificate->resident->first_name }}</title>
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
            top: 35px;
            width: 80px;
            height: 80px;
            object-fit: contain;
            transform: translateY(-50%);
        }
        .logo-left { left: 100px; }
        .logo-right { right: 100px; }
        .official { margin-bottom: 6px; }
        .certificate-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            color: blue;
        }
        .content {
            margin: 1px 0;
            font-size: 13px;
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
        .qr-code {
            position: absolute;
            bottom: 20px;
            left: 20px;
            width: 80px;
        }
        .certificate-number {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 12px;
        }

        /* Force background colors to print */
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
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
        <div class="certificate-number">
            Certificate No: {{ $certificate->certificate_number }}
        </div>

        <div class="header" style="margin-bottom: 10px; padding-bottom: 5px;">
            <div class="header-content" style="padding: 0 90px;">
                @if($barangayDetails)
                    @if($barangayDetails->logo1_path)
                        <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" class="logo-left" alt="Left Logo">
                    @endif
                    @if($barangayDetails->logo2_path)
                        <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" class="logo-right" alt="Right Logo">
                    @endif
                @endif
                <p style="font-size: 14px; font-weight: bold;">REPUBLIC OF THE PHILIPPINES</p>
                <p style="font-size: 14px; font-weight: bold;">PROVINCE OF {{ strtoupper($barangayDetails->province ?? $barangayDetails->province ?? $certificate->resident->province) }}</p>
                <p style="font-size: 14px; font-weight: bold;">MUNICIPALITY OF {{ strtoupper($barangayDetails->city_municipality ?? $barangayDetails->municipality ?? $barangayDetails->city_municipality ?? $barangayDetails->municipality ?? $certificate->resident->city_municipality) }}</p>
                <p style="font-size: 18px; font-weight: bold;">BARANGAY {{ strtoupper($barangayDetails->barangay_name ?? $barangayDetails->barangay ?? $barangayDetails->barangay_name ?? $barangayDetails->barangay ?? $certificate->resident->barangay) }}</p>
                <p style="font-size: 14px; font-weight: bold; font-style: italic;">Office of the Punong Barangay</p>
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

        <br>
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <!-- Left: Officials Column -->
            <div class="official" style="width: 25%; text-align: left;">
                <strong style="font-size: 12px;">BARANGAY COUNCIL MEMBERS:</strong>
                <div class="official" style="font-size: 12px;">
                    <br>
                    @if($captain)
                        <strong style="font-size: 18px;">{{ strtoupper($captain->name) }}</strong><br>
                        <span style="font-size: 15px;">Punong Barangay</span><br>
                        @if($captain->committee)
                            <span style="font-size: 15px;">{{ $captain->committee }}</span>
                        @endif
                    @endif
                    <br>
                </div>
                <div class="official"></div>
                <span style="font-size: 18px;">Barangay Kagawad</span><br>
                @foreach($kagawads as $kagawad)
                    @if(in_array($kagawad->position_id, [12]))
                        <div class="official">
                            <strong>{{ strtoupper($kagawad->name) }}</strong><br>
                            @if($kagawad->committee)
                                {{ $kagawad->committee }}
                            @endif
                        </div>
                    @endif
                @endforeach
                <br>
                @foreach($kagawads as $kagawad)
                    @if(in_array($kagawad->position_id, [11]))
                        <div class="official">
                            <strong>{{ strtoupper($kagawad->name) }}</strong><br>
                            <span>IPM Representative</span><br>
                            @if($kagawad->committee)
                                {{ $kagawad->committee }}
                            @endif
                        </div>
                    @endif
                @endforeach
                @foreach($kagawads as $kagawad)
                    @if(in_array($kagawad->position_id, [10]))
                        <div class="official">
                            <strong>{{ strtoupper($kagawad->name) }}</strong><br>
                            <span>SKC -EX -Officio Member</span><br>
                            @if($kagawad->committee)
                                {{ $kagawad->committee }}
                            @endif
                        </div>
                    @endif
                @endforeach
                <hr>
                @foreach($kagawads as $kagawad)
                    <div class="official">
                        @switch($kagawad->position_id)
                            @case(4)
                                <strong>{{ strtoupper($kagawad->name) }}</strong><br>
                                <span>Barangay Secretary</span><br>
                                @break
                            @case(5)
                                <strong>{{ strtoupper($kagawad->name) }}</strong><br>
                                <span>Barangay Treasurer</span><br>
                                @break
                            @case(9)
                                <strong>{{ strtoupper($kagawad->name) }}</strong><br>
                                <span>Barangay Record Keeper</span><br>
                                @break
                            @case(8)
                                <strong>{{ strtoupper($kagawad->name) }}</strong><br>
                                <span>Assistant BRGY. Secretary</span><br>
                                @break
                        @endswitch
                        @if($kagawad->committee)
                            {{ $kagawad->committee }}
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Divider -->
            <div style="background: #000; width: 2px; margin: 0 15px 0 0; align-self: stretch;"></div>

            <!-- Right: Certificate Content -->
            <div style="width: 70%; display: flex; flex-direction: column; align-items: center; font-size: 15px; font-family: 'Times New Roman', Times, serif;">
                <div class="certificate-title" style="font-family: 'Bookman Old Style', serif;">CERTIFICATE OF DEATH</div>
               
                <div class="content" style="text-align: justify; font-size: 15px;">
                    <h4 style="text-align: left; font-family: 'Times New Roman', Times, serif;"><i>TO WHOM IT MAY CONCERN:</i></h4>
                    <p style="text-indent: 0.5in;">
                        This is to certify that according to the records available in this office,
                        <strong><u>{{ strtoupper($certificate->resident->first_name) }} {{ strtoupper($certificate->resident->middle_name) }} {{ strtoupper($certificate->resident->last_name) }}</u></strong>,
                        {{ \Carbon\Carbon::parse($certificate->resident->birth_date)->diffInYears($certificate->date_of_death) }} years old,
                        {{ $certificate->resident->civil_status }}, {{ $certificate->resident->citizenship }} citizen,
                        and a resident of {{ $certificate->resident->purok ? $certificate->resident->purok->purok_name : $certificate->resident->address }},
                        {{ $barangayDetails->barangay_name ?? $barangayDetails->barangay ?? $barangayDetails->barangay_name ?? $barangayDetails->barangay ?? $certificate->resident->barangay }}, {{ $barangayDetails->city_municipality ?? $barangayDetails->municipality ?? $barangayDetails->city_municipality ?? $barangayDetails->municipality ?? $certificate->resident->city_municipality }},
                        {{ $barangayDetails->province ?? $barangayDetails->province ?? $certificate->resident->province }}, died on
                        <strong>{{ \Carbon\Carbon::parse($certificate->date_of_death)->format('F j, Y') }}</strong> at
                        <strong>{{ $certificate->place_of_death }}</strong> due to
                        <strong>{{ $certificate->cause_of_death }}</strong>.
                    </p>
                    
                    <p style="text-indent: 0.5in;">
                        This certification is issued upon the request of the immediate family for whatever legal purpose it may serve.
                    </p>
                    
                    <p style="text-indent: 0.5in;">
                        Issued this <strong>{{ \Carbon\Carbon::parse($certificate->date_of_issuance)->format('jS') }}</strong> day of <strong>{{ \Carbon\Carbon::parse($certificate->date_of_issuance)->format('F, Y') }}</strong> at Barangay {{ $barangayDetails->barangay_name ?? $barangayDetails->barangay ?? $barangayDetails->barangay_name ?? $barangayDetails->barangay ?? $certificate->resident->barangay }}, {{ $barangayDetails->city_municipality ?? $barangayDetails->municipality ?? $barangayDetails->city_municipality ?? $barangayDetails->municipality ?? $certificate->resident->city_municipality }}, {{ $barangayDetails->province ?? $barangayDetails->province ?? $certificate->resident->province }}.
                    </p>
                </div>
                
                <div class="signature" style="margin-top: 80px; font-size: 17px; margin-left: 250px;">
                    @if($captain)
                        <u><strong>{{ strtoupper($captain->name) }}</strong></u><br>
                        <span style="font-size: 15px;">Punong Barangay</span><br>
                        @if($captain->committee)
                            <span>{{ $captain->committee }}</span>
                        @endif
                    @endif
                    <br>
                </div>
                
                <div style="margin-top: 5px; margin-right: 300px; font-size: 13px; text-align: center;">
                    <div style="border-top: 1px solid #000; width: 200px; margin: 0 auto;"></div>
                    <span>Signature of Next of Kin</span>
                </div>
            </div>
        </div>
        
        <div class="qr-code">
            {!! $qrCode !!}
            <div style="font-size: 8px; text-align: center;">Scan to verify</div>
        </div>
        
        @if($footer)
        <div style="position: absolute; bottom: 20px; left: 0; right: 0; text-align: center; font-size: 12px;">
            <p>{{ $footer->content }}</p>
        </div>
        @endif
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        }
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>
</html>