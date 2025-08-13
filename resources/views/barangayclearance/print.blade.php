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
            top: 35px;
            width: 80px;
            height: 80px;
            object-fit: contain;
            transform: translateY(-50%);
        }
        .logo-left { left: 100px; }
        .logo-right { right: 100px; }
        .official { margin-bottom: 6px; }
        .clearance-title {
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
                <p style="font-size: 14px; font-weight: bold;">PROVINCE OF {{ strtoupper($clearance->resident->province) }}</p>
                <p style="font-size: 14px; font-weight: bold;">MUNICIPALITY OF {{ strtoupper($clearance->resident->city_municipality) }}</p>
                <p style="font-size: 18px; font-weight: bold;">BARANGAY BACUYANGAN</p>
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
                        @if($official_pos3->position)
                            <span style="font-size: 15px;">{{ $official_pos3->committee }}</span>
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
                <br><br>
            </div>

            <!-- Divider -->
            <div style="background: #000; width: 2px; margin: 0 15px 0 0; align-self: stretch;"></div>

            <!-- Right: Clearance Content -->
            <div style="width: 70%; display: flex; flex-direction: column; align-items: center; font-size: 15px; font-family: 'Times New Roman', Times, serif;">
                <div class="clearance-title" style="font-family: 'Bookman Old Style', serif; color: blue;">BARANGAY CERTIFICATE</div>
               
                <div class="content" style="text-align: justify; font-size: 15px;">
                    <h4 style="text-align: left; font-family: 'Times New Roman', Times, serif;"><i>TO WHOM IT MAY CONCERN:</i></h4>
                    <p style="text-indent: 0.5in;">
                        This is to certify that Mr./Ms./Mrs. <strong><u>{{ strtoupper($clearance->resident->full_name) }}</u></strong>,
                        <strong><u>{{ \Carbon\Carbon::parse($clearance->resident->birth_date)->age }}</u> </strong> years old,
                        <strong>{{($clearance->resident->civil_status) }},</strong> and whose signature below is a 
                        Filipino Citizen, a bonafide resident of Barangay Bacuyangan, Hinoba-an, Negros Occidental.
                    </p>
                    <p style="text-indent: 0.5in;">
                        He/She has established residence in Barangay Bacuyangan, Hinoba-an, Negros Occidental for a period of (__)months/(__) years now,
                        and is known to me to be a person of good moral character.
                    </p>

                    <p style="text-indent: 0.5in;">
                       <strong>He/She has not been engaged in any unlawful activity as per Barangay File.</strong>
                    </p>
                    <p style="text-indent: 0.5in;">
                        Issued and signed this <strong> {{ $clearance->date_of_issuance->format('jS') }} </strong> day of 
                        <strong>{{ $clearance->date_of_issuance->format('F') }}, {{ $clearance->date_of_issuance->format('Y') }} </strong> at Barangay Bacuyangan
                        Administration Center for the purpose of <u> <strong>{{ $clearance->purpose }}</strong></u>.
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
                <div style="margin-top: 5px; margin-right: 300px; font-size: 13px; text-align: center;">
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
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>
</html>
