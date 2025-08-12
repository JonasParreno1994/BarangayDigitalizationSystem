<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate Report</title>
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
            <h1>{{ $barangayDetails->heading3 ?? 'BARANGAY CERTIFICATE REPORT' }}</h1>
            <p>Generated on: {{ now()->format('F j, Y h:i A') }}</p>
        </div>
    </div>
    

    <div class="filters">
        <h3 style="margin-top: 0;">Report Filters</h3>
        <div class="filter-item"><strong>Certificate Type:</strong> {{ ucfirst($filters['certificate_type']) }}</div>
        <div class="filter-item"><strong>Status:</strong> {{ ucfirst($filters['status']) }}</div>
        @if($filters['date_from'] || $filters['date_to'])
        <div class="filter-item"><strong>Date Range:</strong> 
            {{ $filters['date_from'] ? \Carbon\Carbon::parse($filters['date_from'])->format('M d, Y') : 'Start' }} 
            to 
            {{ $filters['date_to'] ? \Carbon\Carbon::parse($filters['date_to'])->format('M d, Y') : 'End' }}
        </div>
        @endif
        <div class="filter-item"><strong>Total Records:</strong> {{ $totalCount }}</div>
    </div>

    @if(isset($results['clearances']))
    <div class="certificate-section">
        <h3 class="section-title">Barangay Clearances ({{ $results['clearances']->count() }})</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Resident Name</th>
                    <th>Age</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Date Issued</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results['clearances'] as $clearance)
                <tr>
                    <td>{{ $clearance->id }}</td>
                    <td>{{ $clearance->resident->full_name }}</td>
                    <td>{{ $clearance->resident->birth_date->age }}</td>
                    <td>{{ $clearance->purpose }}</td>
                    <td>{{ ucfirst($clearance->status) }}</td>
                    <td>{{ $clearance->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(isset($results['indigencies']))
    <div class="certificate-section">
        <h3 class="section-title">Barangay Indigencies ({{ $results['indigencies']->count() }})</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Resident Name</th>
                    <th>Age</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Date Issued</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results['indigencies'] as $indigency)
                <tr>
                    <td>{{ $indigency->id }}</td>
                    <td>{{ $indigency->resident->full_name }}</td>
                    <td>{{ $indigency->resident->birth_date->age }}</td>
                    <td>{{ $indigency->purpose }}</td>
                    <td>{{ ucfirst($indigency->status) }}</td>
                    <td>{{ $indigency->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(isset($results['morals']))
    <div class="certificate-section">
        <h3 class="section-title">Certifications of Good Moral ({{ $results['morals']->count() }})</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Resident Name</th>
                    <th>Age</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Date Issued</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results['morals'] as $moral)
                <tr>
                    <td>{{ $moral->id }}</td>
                    <td>{{ $moral->resident->full_name }}</td>
                    <td>{{ $moral->resident->birth_date->age }}</td>
                    <td>{{ $moral->purpose }}</td>
                    <td>{{ ucfirst($moral->status) }}</td>
                    <td>{{ $moral->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(isset($results['residencies']))
    <div class="certificate-section">
        <h3 class="section-title">Certifications of Residency ({{ $results['residencies']->count() }})</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Resident Name</th>
                    <th>Age</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Date Issued</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results['residencies'] as $residency)
                <tr>
                    <td>{{ $residency->id }}</td>
                    <td>{{ $residency->resident->full_name }}</td>
                    <td>{{ $residency->resident->birth_date->age }}</td>
                    <td>{{ $residency->purpose }}</td>
                    <td>{{ ucfirst($residency->status) }}</td>
                    <td>{{ $residency->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

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
