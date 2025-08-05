<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Special Population Report</title>
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
            <h1>{{ $barangayDetails->heading3 ?? 'SPECIAL POPULATION REPORT' }}</h1>
            <p>Generated on: {{ now()->format('F j, Y h:i A') }}</p>
        </div>
    </div>

    <div class="filters">
        <h3 style="margin-top: 0;">Report Filters</h3>
        <div class="filter-item"><strong>Report Type:</strong> 
            @switch($reportType)
                @case('seniors') Senior Citizens @break
                @case('pwds') Persons with Disabilities @break
                @case('solo_parents') Solo Parents @break
                @case('all') All Special Populations @break
            @endswitch
        </div>
        
        @if($reportType === 'seniors' || $reportType === 'all')
            <div class="filter-item"><strong>Age Range:</strong> {{ $ageRange === 'all' ? 'All Ages' : $ageRange }}</div>
        @endif
        
        @if($reportType === 'pwds' || $reportType === 'all')
            <div class="filter-item"><strong>PWD Type:</strong> {{ $pwdType === 'all' ? 'All Types' : $pwdType }}</div>
        @endif
        
        @if($reportType === 'solo_parents' || $reportType === 'all')
            <div class="filter-item"><strong>Civil Status:</strong> {{ $civilStatus === 'all' ? 'All Statuses' : $civilStatus }}</div>
        @endif
        
        <div class="filter-item"><strong>Total Records:</strong> {{ $residents->count() }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Resident Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Category</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($residents as $resident)
            <tr>
                <td>{{ $resident->id }}</td>
                <td>{{ $resident->full_name }}</td>
                <td>{{ $resident->age }}</td>
                <td>{{ $resident->address }}</td>
                <td>{{ $resident->contact_number ?? 'N/A' }}</td>
                <td>
                    @if($resident->is_senior_citizen) Senior Citizen @endif
                    @if($resident->is_pwd) @if($resident->is_senior_citizen), @endif PWD @endif
                    @if($resident->is_solo_parent) 
                        @if($resident->is_senior_citizen || $resident->is_pwd), @endif 
                        Solo Parent 
                    @endif
                </td>
                <td>
                    @if($resident->is_senior_citizen)
                        SC ID: {{ $resident->senior_citizen_id ?? 'N/A' }}<br>
                    @endif
                    @if($resident->is_pwd)
                        PWD ID: {{ $resident->pwd_id ?? 'N/A' }}<br>
                        Type: {{ $resident->pwd_type ?? 'N/A' }}<br>
                    @endif
                    @if($resident->is_solo_parent)
                        SP ID: {{ $resident->solo_parent_id ?? 'N/A' }}<br>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Generated by iBarangay System</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>