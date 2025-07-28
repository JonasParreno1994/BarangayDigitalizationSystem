<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=794px">
    <title>Certificate of Residency - {{ $certificate->resident->full_name }}</title>
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
                <h1>PROVINCE OF {{ strtoupper($certificate->resident->province) }}</h1>
                <h1>MUNICIPALITY OF {{ strtoupper($certificate->resident->city_municipality) }}</h1>
                <p>{{ strtoupper($certificate->resident->barangay) }}</p>
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
                        Certificate No.: {{ $certificate->id ?? '__________' }}
                    </div>
                    <div style="margin-bottom: 6px;">
                        <em>(Revised {{ date('F j, Y') }})</em>
                    </div>
                    <div style="margin-bottom: 6px;">
                        OR No.: {{ $certificate->or_number ?? '__________' }} | Amount Paid: {{ $certificate->amount_paid ? '₱' . number_format($certificate->amount_paid, 2) : '__________' }}
                    </div>
                    <div>
                        Cedula No.: {{ $certificate->cedula_number ?? '__________' }} | Date Issued: {{ $certificate->date_of_issuance->format('m/d/Y') }}
                    </div>
                </div>
                <br><br>
            </div>
            <div style="width: 2px; margin: 0 10px; align-self: stretch; display: flex;">
                <div style="background: #000; width: 100%; height: 100%;"></div>
            </div>
            <!-- Right: Certificate Content -->
            <div style="width: 58%; display: flex; flex-direction: column; align-items: center; font-size: 15px; font-family: 'Times New Roman', Times, serif;">
                <div class="certificate-title" style="font-family: 'Bookman Old Style', serif;">CERTIFICATE OF RESIDENCY</div>
               
                <div class="content" style="text-align: justify; font-size: 15px;">
                    <h4 style="text-align: left; font-family: 'Times New Roman', Times, serif;"><i>TO WHOM IT MAY CONCERN:</i></h4>
                    <p style="text-indent: 0.5in;">
                        This is to certify that <strong><u>{{ strtoupper($certificate->resident->full_name) }}</u></strong>,
                        <strong><u>{{ \Carbon\Carbon::parse($certificate->resident->birth_date)->age }}</u> </strong> years old,
                        <strong>{{ $certificate->resident->civil_status }},</strong> is a bonafide resident of 
                        <strong>{{ $certificate->resident->barangay }}, {{ $certificate->resident->city_municipality }}, 
                        {{ $certificate->resident->province }}</strong>.
                    </p>
                   
                    <p style="text-indent: 0.5in;">
                        This certification is issued upon the request of the above-named person for <strong>{{ $certificate->purpose }}</strong>.
                    </p>
                   
                    <p style="text-indent: 0.5in;">
                        Issued this {{ $certificate->date_of_issuance->format('jS') }} day of 
                        {{ $certificate->date_of_issuance->format('F') }}, {{ $certificate->date_of_issuance->format('Y') }} at 
                        {{ $certificate->resident->barangay }}, {{ $certificate->resident->city_municipality }}, 
                        {{ $certificate->resident->province }}.
                    </p>
                </div>
                <div class="signature" style="margin-top: 80px; font-size: 17px; margin-left: 160px;">
                    @if($official_pos3)
                        <strong>{{ strtoupper($official_pos3->name) }}</strong><br>
                        @if($official_pos3->committee)
                            <span>{{ $official_pos3->committee }}</span>
                        @endif
                    @endif
                    <br>
                </div>
                <div style="margin-top: 50px; margin-right: 300px; font-size: 13px; text-align: center;">
                    <div style="border-top: 1px solid #000; width: 200px; margin: 0 auto;"></div>
                    <span>Signature of Applicant</span>
                    <div style="margin-top: 20px; display: flex; flex-direction: column; align-items: center;">
                        <div style="width: 100px; height: 100px; border: 1px solid #000; margin-top: 5px;"></div>
                        <span>Right Thumb Mark</span>
                    </div>
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