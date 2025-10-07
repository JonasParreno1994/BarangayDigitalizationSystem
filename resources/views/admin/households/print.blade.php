<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBI FORM A - Household Record</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0.5in;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.2;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .form-header {
            margin-bottom: 20px;
        }

        .form-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .main-title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin: 20px 0;
        }
        
        .header-info {
            margin-bottom: 20px;
        }
        
        .header-row {
            display: flex;
            width: 100%;
            margin-bottom: 8px;
            align-items: center;
        }
        
        .header-label {
            font-weight: bold;
            width: 150px;
            padding-right: 10px;
            font-size: 11px;
        }
        
        .header-value {
            border-bottom: 1px solid #000;
            padding: 2px 8px;
            font-size: 11px;
            min-height: 18px;
            flex: 1;
        }
        
        .members-table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }
        
        .members-table th,
        .members-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
            vertical-align: top;
            font-size: 8px;
        }
        
        .members-table th {
            background-color: #90EE90;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .members-table .name-header {
            background-color: #90EE90;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
        }
        
        .members-table .name-subheader {
            background-color: #90EE90;
            font-weight: bold;
            font-size: 9px;
            padding: 2px;
        }
        
        .signature-section {
            margin-top: 15px;
        }
        
        .signature-section table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .signature-section td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            vertical-align: bottom;
            height: 80px;
        }
        
        .signature-label {
            font-weight: bold;
            font-size: 9px;
            margin-bottom: 25px;
        }
        
        .signature-name {
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            font-size: 8px;
            padding-top: 2px;
            font-style: italic;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 72px;
            color: rgba(128, 128, 128, 0.1);
            font-weight: bold;
            z-index: -1;
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        
        .print-button {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            z-index: 1000;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="watermark">{{ $household->barangay ?? 'iBarangay' }}</div>

    <div class="main-title">RECORDS OF BARANGAY INHABITANTS BY HOUSEHOLD</div>
    
    <div class="header-info">
        <div class="header-row">
            <div class="header-label">REGION :</div>
            <div class="header-value">{{ $household->region ?? '' }}</div>
        </div>
        <div class="header-row">
            <div class="header-label">PROVINCE :</div>
            <div class="header-value">{{ $household->province ?? '' }}</div>
        </div>
        <div class="header-row">
            <div class="header-label">CITY/MUNICIPALITY :</div>
            <div class="header-value">{{ $household->city_municipality ?? '' }}</div>
        </div>
        <div class="header-row">
            <div class="header-label">BARANGAY :</div>
            <div class="header-value">{{ $household->barangay ?? '' }}</div>
        </div>
        <div class="header-row">
            <div class="header-label">HOUSEHOLD ADDRESS :</div>
            <div class="header-value">{{ $household->household_address ?? '' }}</div>
        </div>
        <div class="header-row">
            <div class="header-label">NO. OF HOUSEHOLD MEMBERS :</div>
            <div class="header-value">{{ $household->number_of_members }}</div>
        </div>
    </div>

  
    <table class="members-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 8%;">LAST NAME</th>
                <th rowspan="2" style="width: 8%;">FIRST NAME</th>
                <th rowspan="2" style="width: 8%;">MIDDLE NAME</th>
                <th rowspan="2" style="width: 4%;">EXT</th>
                <th rowspan="2" style="width: 10%;">PLACE OF BIRTH</th>
                <th rowspan="2" style="width: 8%;">DATE OF BIRTH</th>
                <th rowspan="2" style="width: 4%;">AGE</th>
                <th rowspan="2" style="width: 4%;">SEX</th>
                <th rowspan="2" style="width: 8%;">CIVIL STATUS</th>
                <th rowspan="2" style="width: 8%;">CITIZENSHIP</th>
                <th rowspan="2" style="width: 10%;">OCCUPATION</th>
                <th style="width: 20%;">
                    Indicate if Labor/employed, Unemployed, PWD, Solo Parent, Out of School Youth (OSY), Out of School Children (OSC) and/or IP
                </th>
            </tr>
        </thead>
        <tbody>
            @php $maxRows = 8; @endphp
            @for($i = 0; $i < $maxRows; $i++)
                @php $member = $household->members[$i] ?? null; @endphp
                <tr style="height: 30px;">
                    <td>{{ $member ? $member->last_name : '' }}</td>
                    <td>{{ $member ? $member->first_name : '' }}</td>
                    <td>{{ $member ? $member->middle_name : '' }}</td>
                    <td>{{ $member ? $member->extension : '' }}</td>
                    <td>{{ $member ? $member->place_of_birth : '' }}</td>
                    <td>{{ $member && $member->date_of_birth ? $member->date_of_birth->format('m/d/Y') : '' }}</td>
                    <td>{{ $member ? $member->calculated_age : '' }}</td>
                    <td>{{ $member ? $member->sex : '' }}</td>
                    <td>{{ $member ? $member->civil_status : '' }}</td>
                    <td>{{ $member ? $member->citizenship : '' }}</td>
                    <td>{{ $member ? $member->occupation : '' }}</td>
                    <td>{{ $member ? $member->labor_employment_status : '' }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

   
    <div class="signature-section">
        <table>
            <tr>
                <td style="width: 33.33%;">
                    <div class="signature-label">Prepared by:</div>
                    <div class="signature-name">
                        {{ $household->householdHead ? $household->householdHead->first_name . ' ' . ($household->householdHead->middle_name ? substr($household->householdHead->middle_name, 0, 1) . '. ' : '') . $household->householdHead->last_name . ($household->householdHead->extension ? ' ' . $household->householdHead->extension : '') : 'Name of Household/Head Member' }}
                    </div>
                    <div class="signature-line">
                        <div><span style="font-weight: bold;">Name of Household/Head Member</span></div>
                        (Signature over Printed Name)
                    </div>
                </td>
                <td style="width: 33.33%;">
                    <div class="signature-label">Certified Correct:</div>
                    <div class="signature-name">
                        {{ $barangaySecretary ? $barangaySecretary->name : '' }}
                    </div>
                    <div class="signature-line">
                        <div><span style="font-weight: bold;">Barangay Secretary</span></div>
                        (Signature over Printed Name)
                    </div>
                </td>
                <td style="width: 33.34%;">
                    <div class="signature-label">Validated by:</div>
                    <div class="signature-name">
                        {{ $punongBarangay ? $punongBarangay->name : '' }}
                    </div>
                    <div class="signature-line">
                            <div><span style="font-weight: bold;">Punong Barangay</span></div>
                        (Signature over Printed Name)
                    </div>
                </td>
            </tr>
        </table>
    </div>

   
    <div style="margin-top: 10px; font-size: 7px; text-align: justify; border: 1px solid #000; padding: 4px;">
        I hereby certify that the above information are true and correct to the best of my knowledge. I understand that for the Barangay to carry out its mandate pursuant to Section 394 (d)(6) of the Local Government Code of 1991, they must necessarily process my personal information for easy identification of inhabitants, as a tool in planning, and as an updated reference in the number of inhabitants of the Barangay. Therefore, I grant my consent and recognize the authority of the Barangay to process my personal information, subject to the provisions of Republic Act 10173 or the Data Privacy Act of 2012.
    </div>

    <script>

        window.onload = function() {
           
            window.print();
        }
        
       
        window.onafterprint = function() {
          
            window.close();
        }
        
      
        window.onbeforeprint = function() {
            
            console.log('Preparing to print...');
        }
        
        
        if (window.opener) {
           
            setTimeout(function() {
                if (!window.onafterprint) {
                 
                    window.close();
                }
            }, 2000);
        }
        
     
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                window.close();
            }
        });
    </script>
</body>
</html>
