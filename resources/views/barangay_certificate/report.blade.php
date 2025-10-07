<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Certificate Report</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            background: #fff;
            color: #000;
            margin: 0;
            padding: 20px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
        }
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
        }
        .header p {
            margin: 0;
            font-size: 13px;
        }
        .header img {
            max-width: 80px;
            max-height: 80px;
            position: absolute;
            top: 0;
        }
        .header .logo-left {
            left: 0;
        }
        .header .logo-right {
            right: 0;
        }
        .report-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 25px;
            text-transform: uppercase;
        }
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background: #f2f2f2;
            border: 1px solid #ccc;
        }
        .filter-item {
            margin: 4px 0;
            font-size: 13px;
        }
        .section-title {
            font-weight: bold;
            font-size: 16px;
            background: #e0e0e0;
            padding: 6px 10px;
            margin-top: 30px;
            border-left: 5px solid #444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px 10px;
            font-size: 13px;
            text-align: left;
        }
        th {
            background: #d9d9d9;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        @page {
            size: A4;
            margin: 15mm;
        }
        @media print {
            body { background: #fff; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        @if(isset($barangayDetails))
            @if($barangayDetails->logo1_path)
                <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" class="logo-left" style="left:0;">
            @endif
            @if($barangayDetails->logo2_path)
                <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" class="logo-right" style="right:0;">
            @endif
        @endif
        <h1>REPUBLIC OF THE PHILIPPINES</h1>
        <h1>PROVINCE OF {{ $barangayDetails->heading1}}</h1>
        <h1>MUNICIPALITY OF {{ $barangayDetails->heading2}}</h1>
        <h1>BARANGAY {{ $barangayDetails->heading3}}</h1>
        <p>Generated on: {{ now()->format('F j, Y h:i A') }}</p>
    </div>

    <div class="report-title">Barangay Certificate Report</div>

    <div class="filters">
        <h3 style="margin-top: 0;">Report Filters</h3>
        <div class="filter-item"><strong>Report Period:</strong>
            {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
        </div>
        <div class="filter-item"><strong>Total Records:</strong> {{ $reportData->count() }}</div>
    </div>

    @if($reportData->count() > 0)
        <div class="certificate-section">
            <h3 class="section-title">Barangay Certificates ({{ $reportData->count() }})</h3>
            <table>
            <thead>
                <tr>
                    <th style="width: 8%;">ID</th>
                    <th style="width: 25%;">Resident Name</th>
                    <th style="width: 20%;">Purpose</th>
                    <th style="width: 12%;">Date Issued</th>
                    <th style="width: 10%;">OR Number</th>
                    <th style="width: 10%;">Amount</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 5%;">Cedula</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData as $certificate)
                    <tr>
                        <td>{{ $certificate->id }}</td>
                        <td>
                            @if($certificate->resident)
                                {{ $certificate->resident->last_name }}, {{ $certificate->resident->first_name }} {{ $certificate->resident->middle_name }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $certificate->purpose }}</td>
                        <td>{{ $certificate->date_of_issuance->format('m/d/Y') }}</td>
                        <td>{{ $certificate->or_number ?? '-' }}</td>
                        <td>
                            @if($certificate->amount_paid)
                                ₱{{ number_format($certificate->amount_paid, 2) }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $certificate->status }}</td>
                        <td>{{ $certificate->cedula_number ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="section-title">Summary Statistics</div>
        <table style="width: 50%; margin-top: 10px;">
            <tbody>
                <tr>
                    <td style="font-weight: bold;">Total Certificates:</td>
                    <td>{{ $reportData->count() }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Issued:</td>
                    <td>{{ $reportData->where('status', 'Issued')->count() }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Pending:</td>
                    <td>{{ $reportData->where('status', 'Pending')->count() }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Cancelled:</td>
                    <td>{{ $reportData->where('status', 'Cancelled')->count() }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Total Amount Collected:</td>
                    <td>₱{{ number_format($reportData->where('amount_paid', '>', 0)->sum('amount_paid'), 2) }}</td>
                </tr>
            </tbody>
        </table>
        </div>
    @else
        <div class="no-data">
            <p>No certificates found for the selected date range.</p>
            <p>Period: {{ date('F d, Y', strtotime($dateFrom)) }} to {{ date('F d, Y', strtotime($dateTo)) }}</p>
        </div>
    @endif

    <div class="footer">
        <p>This report was generated automatically by the Barangay Management System.</p>
        <p>Print Date: {{ date('F d, Y h:i A') }}</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() {
                if (window.history.length > 1) {
                    window.history.back();
                } else {
                    window.close();
                }
            }, 1000);
        };
    </script>
</body>
</html>