<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBI Form C - Monitoring Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
            background: white;
            padding: 0;
        }

        .container {
            width: 8.5in;
            min-height: 11in;
            margin: 0 auto;
            padding: 0.3in;
            background: white;
            position: relative;
        }

        .header-section {
            display: table;
            width: 100%;
            margin-bottom: 10px;
            position: relative;
        }

        .logo-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 60px;
            height: 60px;
            z-index: 1;
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .form-identifier {
            position: absolute;
            top: 0;
            left: 0;
            font-size: 12px;
            font-weight: bold;
        }

        .header-content {
            text-align: center;
            padding: 0 80px;
            margin-top: 5px;
        }

        .header-content h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }

        .header-content p {
            font-size: 10px;
            margin: 1px 0;
        }

        .region-info {
            margin: 8px 0;
            font-size: 10px;
        }

        .region-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }

        .region-info-row div {
            flex: 1;
        }

        .totals-section {
            margin: 8px 0;
            font-size: 10px;
            line-height: 1.2;
        }

        .totals-section p {
            margin-bottom: 1px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 9px;
            border: 2px solid #000;
        }

        .data-table th {
            background-color: #f0f0f0;
            border: 1px solid #000;
            padding: 3px 2px;
            text-align: center;
            font-weight: bold;
            font-size: 8px;
            vertical-align: middle;
        }

        .data-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            vertical-align: middle;
            font-size: 8px;
        }

        .data-table .category-cell {
            text-align: left;
            padding-left: 4px;
            font-weight: normal;
            width: 35%;
        }

        .data-table .number-cell {
            text-align: center;
            font-weight: normal;
            width: 12%;
        }

        .data-table .total-cell {
            text-align: center;
            font-weight: bold;
            width: 12%;
        }

        .data-table .remarks-cell {
            text-align: center;
            font-size: 7px;
            width: 15%;
        }

        .population-header {
            font-weight: bold;
            background-color: #f8f8f8;
        }

        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .signatures-section {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
        }

        .signature-block {
            width: 45%;
            text-align: center;
        }

        .signature-block p {
            margin-bottom: 2px;
            font-weight: bold;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            height: 30px;
            margin: 8px 0 3px 0;
            position: relative;
        }

        .signature-name {
            font-weight: bold;
            text-transform: uppercase;
            margin: 3px 0 1px 0;
        }

        .signature-title {
            margin: 1px 0;
        }

        .signature-note {
            font-size: 7px;
            margin: 1px 0;
            font-style: italic;
        }

        .date-section {
            margin-top: 8px;
        }

        .date-line {
            border-bottom: 1px solid #000;
            width: 120px;
            height: 15px;
            margin: 3px auto;
        }

        .footer-note {
            margin-top: 15px;
            font-size: 7px;
            text-align: left;
            font-style: italic;
        }

        .footer-note strong {
            font-weight: bold;
        }

        @media print {
            body { 
                margin: 0;
                padding: 0;
                font-size: 8px;
            }
            
            .container {
                width: auto;
                margin: 0;
                padding: 0.2in;
                min-height: auto;
                page-break-inside: avoid;
            }
            
            .data-table {
                font-size: 7px;
                page-break-inside: avoid;
                margin: 5px 0;
            }
            
            .data-table th,
            .data-table td {
                padding: 1px;
                font-size: 7px;
            }
            
            .header-section {
                page-break-after: avoid;
                margin-bottom: 8px;
            }
            
            .signatures-section {
                page-break-inside: avoid;
                margin-top: 15px;
            }

            .logo-container {
                width: 50px;
                height: 50px;
            }

            .header-content h2 {
                font-size: 12px;
            }

            .header-content p {
                font-size: 9px;
            }

            .region-info,
            .totals-section {
                font-size: 8px;
                margin: 5px 0;
            }

            .signatures-section {
                font-size: 7px;
            }

            .footer-note {
                font-size: 6px;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header-section">
            <!-- Logo -->
            <div class="logo-container">
                @if($barangayDetails && $barangayDetails->logo1_path)
                    <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" alt="Barangay Logo">
                @else
                    <img src="{{ asset('1.jfif') }}" alt="Barangay Logo">
                @endif
            </div>

            <!-- Header Content -->
            <div class="header-content">
                <h2>MONITORING REPORT</h2>
                <p>For {{ ucfirst($semester) }} ({{ $semester === 'first' ? '1st' : '2nd' }}) Semester of CY {{ $year }}</p>
            </div>
        </div>

        <!-- Regional Information -->
        <div class="region-info">
            <div class="region-info-row">
                <div><strong>REGION:</strong> {{ $barangayDetails->region ?? 'VI' }}</div>
                <div></div>
            </div>
            <div class="region-info-row">
                <div><strong>PROVINCE:</strong> {{ $barangayDetails->province ?? 'NEGROS OCCIDENTAL' }}</div>
                <div></div>
            </div>
            <div class="region-info-row">
                <div><strong>MUNICIPALITY:</strong> {{ $barangayDetails->city_municipality ?? 'HINOBA-AN' }}</div>
                <div></div>
            </div>
            <div class="region-info-row">
                <div><strong>BARANGAY:</strong> {{ $barangayDetails->barangay ?? 'BACUYANGAN' }}</div>
                <div></div>
            </div>
        </div>

        <!-- Population Totals -->
        <div class="totals-section">
            @php
                $totalPopulation = array_sum(array_column($populationData, 'total'));
                $totalHouseholds = $residents->whereNotNull('household_number')->groupBy('household_number')->count();
                if ($totalHouseholds == 0) {
                    $totalHouseholds = ceil($totalPopulation / 4.5); // Average household size estimate
                }
            @endphp
            <p><strong>Total No. of Barangay Inhabitants:</strong> {{ $totalPopulation }}</p>
            <p><strong>Total No. of Households:</strong> {{ $totalHouseholds }}</p>
            <p><strong>Total No. Families:</strong> {{ $totalHouseholds }}</p>
        </div>

        <!-- Population Data Table -->
        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2" class="category-cell">INDICATORS</th>
                    <th class="number-cell">MALE</th>
                    <th class="number-cell">FEMALE</th>
                    <th class="total-cell">TOTAL</th>
                    <th rowspan="2" class="remarks-cell">REMARKS</th>
                </tr>
            </thead>
            <tbody>
                <!-- Population by Age Group Header -->
                <tr class="population-header">
                    <td class="category-cell"><strong>Population by Age Bracket:</strong></td>
                    <td class="number-cell"></td>
                    <td class="number-cell"></td>
                    <td class="total-cell"></td>
                    <td class="remarks-cell"></td>
                </tr>

                <!-- Age Groups Data -->
                @foreach($populationData as $ageRange => $data)
                <tr>
                    <td class="category-cell">{{ $ageRange }}</td>
                    <td class="number-cell">{{ $data['male'] }}</td>
                    <td class="number-cell">{{ $data['female'] }}</td>
                    <td class="total-cell">{{ $data['total'] }}</td>
                    <td class="remarks-cell">BHW data</td>
                </tr>
                @endforeach

                <!-- Total Population by Sex -->
                @php
                    $totalMale = array_sum(array_column($populationData, 'male'));
                    $totalFemale = array_sum(array_column($populationData, 'female'));
                    $grandTotal = $totalMale + $totalFemale;
                @endphp
                <tr class="total-row">
                    <td class="category-cell"><strong>Population by Sex:</strong></td>
                    <td class="number-cell"><strong>{{ $totalMale }}</strong></td>
                    <td class="number-cell"><strong>{{ $totalFemale }}</strong></td>
                    <td class="total-cell"><strong>{{ $grandTotal }}</strong></td>
                    <td class="remarks-cell"><strong>BHW data</strong></td>
                </tr>

                <!-- Labor Force -->
                <tr>
                    <td class="category-cell">Labor Force</td>
                    <td class="number-cell" colspan="2">{{ $laborForceData['labor_force'] }}</td>
                    <td class="total-cell">{{ $laborForceData['labor_force'] }}</td>
                    <td class="remarks-cell">BHW data</td>
                </tr>

                <tr>
                    <td class="category-cell">Unemployed</td>
                    <td class="number-cell" colspan="2">{{ $laborForceData['unemployed'] }}</td>
                    <td class="total-cell">{{ $laborForceData['unemployed'] }}</td>
                    <td class="remarks-cell">BHW data</td>
                </tr>

                <!-- Out of School Categories -->
                <tr>
                    <td class="category-cell">Out of School Children (OSC)<br>(6-14 years old)</td>
                    <td class="number-cell" colspan="2">{{ $outOfSchoolData['osc'] }}</td>
                    <td class="total-cell">{{ $outOfSchoolData['osc'] }}</td>
                    <td class="remarks-cell">BHW data</td>
                </tr>

                <tr>
                    <td class="category-cell">Out of School Youth (OSY)<br>(15-24 years old)</td>
                    <td class="number-cell" colspan="2">{{ $outOfSchoolData['osy'] }}</td>
                    <td class="total-cell">{{ $outOfSchoolData['osy'] }}</td>
                    <td class="remarks-cell">BHW data</td>
                </tr>

                <!-- Special Populations -->
                <tr>
                    <td class="category-cell">Persons with Disabilities (PWD)</td>
                    <td class="number-cell" colspan="2">{{ $pwdData }}</td>
                    <td class="total-cell">{{ $pwdData }}</td>
                    <td class="remarks-cell">BHW data</td>
                </tr>

                <tr>
                    <td class="category-cell">Overseas Filipino Workers (OFWs)</td>
                    <td class="number-cell" colspan="2">{{ $ofwData }}</td>
                    <td class="total-cell">{{ $ofwData }}</td>
                    <td class="remarks-cell">BHW data</td>
                </tr>

                <tr>
                    <td class="category-cell">Indigenous People (IPs)</td>
                    <td class="number-cell" colspan="2">{{ $indigenousData }}</td>
                    <td class="total-cell">{{ $indigenousData }}</td>
                    <td class="remarks-cell">BHW data</td>
                </tr>

                <!-- Additional Categories -->
                @php
                    $marriedCount = $residents->where('civil_status', 'Married')->count();
                    $outOfSchoolMinors = $residents->filter(function($resident) {
                        if ($resident->birth_date) {
                            $age = \Carbon\Carbon::parse($resident->birth_date)->age;
                            return $age >= 5 && $age <= 17 && (!$resident->education_status || $resident->education_status === 'Not Attending');
                        }
                        return false;
                    })->count();
                @endphp
                
                <tr>
                    <td class="category-cell">Out of School Minors</td>
                    <td class="number-cell" colspan="2"></td>
                    <td class="total-cell">{{ $outOfSchoolMinors }}</td>
                    <td class="remarks-cell">BHW data</td>
                </tr>

                <tr>
                    <td class="category-cell">Married</td>
                    <td class="number-cell" colspan="2"></td>
                    <td class="total-cell">{{ $marriedCount }}</td>
                    <td class="remarks-cell">BHW data</td>
                </tr>

                <!-- Citizenship -->
                <tr>
                    <td class="category-cell">Citizenship: Filipino</td>
                    <td class="number-cell" colspan="2"></td>
                    <td class="total-cell">{{ $citizenshipData['filipino'] }}</td>
                    <td class="remarks-cell">BHW data</td>
                </tr>

                <tr>
                    <td class="category-cell">Citizenship: Foreigner</td>
                    <td class="number-cell" colspan="2"></td>
                    <td class="total-cell">{{ $citizenshipData['foreigner'] }}</td>
                    <td class="remarks-cell">BHW data</td>
                </tr>
            </tbody>
        </table>

        <!-- Signature Section -->
        <div class="signatures-section">
            <div class="signature-block">
                <p>Prepared by:</p>
                <div class="signature-line"></div>
                <div class="signature-name">{{ $barangayDetails->secretary_name ?? 'ROWENA A. MINAVES' }}</div>
                <div class="signature-title">Barangay Secretary</div>
                <div class="signature-note">(Signature over Printed Name)</div>
                
                <div class="date-section">
                    <p><strong>Date Accomplished:</strong></p>
                    <div class="date-line"></div>
                </div>
            </div>

            <div class="signature-block">
                <p>Submitted by:</p>
                <div class="signature-line"></div>
                <div class="signature-name">{{ $barangayDetails->captain_name ?? 'JOHNNY RAY L. RELIQUIAS' }}</div>
                <div class="signature-title">Punong Barangay</div>
                <div class="signature-note">(Signature over Printed Name)</div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="footer-note">
            <p><strong>Note:</strong> This RBI Form C (Barangay Monitoring Report) is to be submitted to DILG/LGU-RD as a reference for encoding the RBI/BPIS.</p>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
            
            window.onafterprint = function() {
                window.close();
            };
        };
    </script>
</body>
</html>
