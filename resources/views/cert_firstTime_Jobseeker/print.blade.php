<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=794px">
    <title>Certificate for First Time Jobseekers - {{ $cert->resident->full_name }}</title>
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
            text-transform: uppercase;
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
                <p style="font-size: 14px; font-weight: bold;">PROVINCE OF {{ strtoupper($cert->resident->province) }}</p>
                <p style="font-size: 14px; font-weight: bold;">MUNICIPALITY OF {{ strtoupper($cert->resident->city_municipality) }}</p>
                <p style="font-size: 18px; font-weight: bold;">BARANGAY {{ strtoupper($cert->resident->barangay) }}</p>
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
                    @php
                        $official_pos3 = $officials->first(fn($official) => $official->position_id == 3);
                    @endphp
                    @if($official_pos3)
                        <strong style="font-size: 18px;">{{ strtoupper($official_pos3->name) }}</strong><br>
                        <span style="font-size: 15px;">Punong Barangay</span><br>
                        @if($official_pos3->committee)
                            <span style="font-size: 15px;">{{ $official_pos3->committee }}</span>
                        @endif
                    @endif
                    <br>
                </div>

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
                @php
                $order = [4 => 1, 5 => 2, 9 => 3, 8 => 4];
                $sortedKagawads = $kagawads->sortBy(function($item) use ($order) {
                    return $order[$item->position_id] ?? 999;
                });
                @endphp
                @foreach($sortedKagawads as $kagawad)
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
                <br><br>
                <div style="text-align: left; width: 100%; align-self: flex-start; line-height:5px; font-size: 10px;">
                    <div style="margin-bottom: 6px;">
                        Certificate No.: {{ $cert->id ?? '__________' }}
                    </div>
                    <div style="margin-bottom: 6px;">
                        <em>(Revised {{ date('F j, Y') }})</em>
                    </div>
                    <div style="margin-bottom: 6px;">
                        OR No.: {{ $cert->or_number ?? '__________' }} | Amount Paid: {{ $cert->amount_paid ? '₱' . number_format($cert->amount_paid, 2) : '__________' }}
                    </div>
                    <div>
                        Date Issued: {{ $cert->date_of_issuance->format('m/d/Y') }}
                    </div>
                    <div style="margin-top: 8px;">
                        VALID UNTIL {{ $cert->date_of_issuance->addYear()->format('F j, Y') }}
                    </div>
                </div>
                <br><br>
            </div>

            <!-- Divider -->
            <div style="background: #000; width: 2px; margin: 0 15px 0 0; align-self: stretch;"></div>

            <!-- Right: Certificate Content -->
            <div style="width: 70%; display: flex; flex-direction: column; align-items: center; font-size: 15px; font-family: 'Times New Roman', Times, serif;">
                <div class="certificate-title" style="font-family: 'Bookman Old Style', serif; color: blue; margin-bottom: 30px;">BARANGAY CERTIFICATE
                     <p style="font-size: 14px; margin-top: 1px;"><strong>(First Time Jobseekers Assistance Act -RA 11261)</strong></p></div>
                <div class="content" style="text-align: justify; font-size: 15px;">
                    <p style="text-indent: 0.5in;">
                        This is to certify that Mr./Ms./Mrs. <strong><u>{{ strtoupper($cert->resident->full_name) }}</u></strong>, a resident of 
                        <strong>{{ $cert->purok }}</strong>, Barangay Bacuyangan, for <strong><u>{{ \Carbon\Carbon::parse($cert->resident->birth_date)->age }}</u> </strong>
                        years, is a qualified availee of <strong>RA 11261 </strong> or the <strong>FIRS-TIME Jobseeker Act of 2019.</strong>
                    </p>
                    <p style="text-indent: 0.5in;">
                       I further certify that the holder/bearer was informed of his/her rights, including the duties and responsibilities accorded by RA 11261
                       through the Oath of Undertaking he/she has assigned and executed in the presence of our barangay official.
                    </p>
                    
                    
                    <p style="text-indent: 0.5in;">
                        Isued and signed this <strong> {{ $cert->date_of_issuance->format('jS') }} </strong> of 
                       <strong> {{ $cert->date_of_issuance->format('F') }}</strong>, <strong>{{ $cert->date_of_issuance->format('Y') }}</strong>
                        at Barangay Bacuyangan Administration Center.
                    </p>
                </div>
                <div class="signature" style="margin-top: 80px; font-size: 17px; margin-left: 250px;">
                    @if($official_pos3)
                        <u><strong>{{ strtoupper($official_pos3->name) }}</strong></u><br>
                        <span style="font-size: 15px;">Punong Barangay</span><br>
                        @if($official_pos3->committee)
                            <span>{{ $official_pos3->committee }}</span>
                        @endif
                    @endif
                    <br>
                </div>
                <div style="margin-top: 5px; margin-right: 250px; font-size: 13px; text-align: center;">
                    <strong><u>{{ strtoupper($cert->resident->full_name) }}</u></strong>
                    <br>
                    <span>Name and Signature of Applicant</span>
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
        window.onafterprint = function() {
            window.history.back(); 
        };
    </script>
</body>
</html>
