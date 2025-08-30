<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Good Moral Certificate Report</title>
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
            .no-print {
                display: none;
            }
            body {
                margin: 0;
            }
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
        <h1>{{ $barangayDetails->heading1 ?? 'REPUBLIC OF THE PHILIPPINES' }}</h1>
        <h1>{{ $barangayDetails->heading2 ?? 'PROVINCE / MUNICIPALITY' }}</h1>
        <h1>{{ $barangayDetails->heading3 ?? 'BARANGAY CERTIFICATE REPORT' }}</h1>
        <p>Generated on: {{ now()->format('F j, Y h:i A') }}</p>
    </div>

    <div class="report-title">Barangay Good Moral Certificate Report</div>

    <div class="filters">
        <h3 style="margin-top: 0;">Report Filters</h3>
        <div class="filter-item"><strong>Report Period:</strong>
            {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
        </div>
        <div class="filter-item"><strong>Total Records:</strong> {{ $reportData->count() }}</div>
    </div>

    <div class="certificate-section">
        <h3 class="section-title">Barangay Good Moral Certificate ({{ $reportData->count() }})</h3>
        @if($reportData->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Resident Name</th>
                    <th>Purpose</th>
                    <th>Date Issued</th>
                    <th>Cedula Number</th>
                    <th>OR Number</th>
                    <th>Amount Paid</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData as $index => $cert)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $cert->resident->last_name }}, {{ $cert->resident->first_name }} {{ $cert->resident->middle_name }}</td>
                    <td>{{ Str::limit($cert->purpose, 25) }}</td>
                    <td>{{ $cert->date_of_issuance->format('m/d/Y') }}</td>
                    <td>{{ $cert->cedula_number ?? 'N/A' }}</td>
                    <td>{{ $cert->or_number ?? 'N/A' }}</td>
                    <td>₱{{ number_format($cert->amount_paid ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="no-data">
            <h3>No Records Found</h3>
            <p>No Barangay Good Moral Certificate records found for the selected date range.</p>
        </div>
        @endif
    </div>

    <div class="footer">
        <p>Generated by Barangay Management System</p>
        <p>{{ now()->format('F j, Y h:i A') }}</p>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
        
        // Optional: Close window after printing (remove this if you don't want auto-close)
        window.onafterprint = function() {
            window.history.back(); // Go back to the previous page instead of closing
        };
    </script>
</body>
</html>
