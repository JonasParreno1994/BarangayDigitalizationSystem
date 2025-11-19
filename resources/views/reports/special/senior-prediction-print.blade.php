<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior Citizen Prediction Report - {{ $predictionYear }}</title>
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
        <div style="position: relative;">
            @if($barangayDetails)
                @if($barangayDetails->logo1_path)
                    <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" style="position: absolute; left: 0; top: 0; width: 80px; height: 80px; object-fit: contain;">
                @endif
                @if($barangayDetails->logo2_path)
                    <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" style="position: absolute; right: 0; top: 0; width: 80px; height: 80px; object-fit: contain;">
                @endif
            @endif
    
            <h1>{{ $barangayDetails->heading1 ?? 'REPUBLIC OF THE PHILIPPINES' }}</h1>
            <h1>{{ $barangayDetails->heading2 ?? 'PROVINCE / MUNICIPALITY' }}</h1>
            <h1>{{ $barangayDetails->heading3 ?? 'SENIOR CITIZEN PREDICTION REPORT' }}</h1>
            <p>Generated on: {{ now()->format('F j, Y h:i A') }}</p>
        </div>
    </div>

    <div class="filters">
        <h3 style="margin-top: 0;">Report Filters</h3>
        <div class="filter-item"><strong>Prediction Year:</strong> {{ $predictionYear }}</div>
        <div class="filter-item"><strong>Month Filter:</strong> {{ $month ? date('F', mktime(0, 0, 0, $month, 1)) : 'All Months' }}</div>
        <div class="filter-item"><strong>Purok:</strong> {{ $purok ? $purok->purok_name : 'All Puroks' }}</div>
        <div class="filter-item"><strong>Total Records:</strong> {{ $residents->count() }} (Male: {{ $residents->where('sex', 'Male')->count() }}, Female: {{ $residents->where('sex', 'Female')->count() }})</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Resident Name</th>
                <th>Birth Date</th>
                <th>Current Age</th>
                <th>Sex</th>
                <th>Address</th>
                <th>Purok</th>
                <th>Contact Number</th>
                <th>Civil Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($residents as $resident)
            <tr>
                <td>{{ $resident->id }}</td>
                <td>{{ $resident->full_name }}</td>
                <td>{{ $resident->birth_date->format('M d, Y') }}</td>
                <td>{{ $resident->age }}</td>
                <td>{{ $resident->sex }}</td>
                <td>{{ $resident->address ?? 'N/A' }}</td>
                <td>{{ $resident->purok->purok_name ?? 'N/A' }}</td>
                <td>{{ $resident->contact_number ?? 'N/A' }}</td>
                <td>{{ $resident->civil_status ?? 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center; padding: 20px;">
                    No residents found for the selected criteria
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Generated by iBarangay System</p>
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
