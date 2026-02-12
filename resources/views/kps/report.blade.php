<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KP Case Report</title>
    <style>
        @page { size: A4 landscape; margin: 12mm; }
        body { font-family: 'Times New Roman', Times, serif; margin:0; padding:0; background:#fff; color:#000 }
        .page { width:270mm; margin:0 auto; padding:10mm; box-sizing:border-box }
        .header { position:relative; text-align:center; padding-bottom:8px; padding-left:0; background: linear-gradient(135deg, #00b894 0%, #fdcb6e 50%, #0984e3 100%) }
        .logo-left { position:absolute; left:55mm; top:.05mm; width:90px; height:90px; object-fit:contain }
        .logo-right { position:absolute; right:55mm; top:.05mm; width:90px; height:90px; object-fit:contain }
        .header .gov { font-weight:700;font-family: Calisto MT; font-size:13px; margin:2px 0 }
        .header .barangay { font-weight:900; font-size:20px; margin:4px 0; color:#0b5ed7 }
        .office { font-weight:700; font-style:italic; font-size:14px; color:#0b5ed7 }
        .report-title { text-align:center; font-size:24px; font-weight:700; margin:20px 0 10px; text-transform:uppercase }
        
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background: #f2f2f2;
            border: 1px solid #ccc;
            font-size: 12px;
        }
        .filter-item { margin: 4px 0; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 30px; }
        th, td { border: 1px solid #333; padding: 6px 8px; font-size: 11px; text-align: left; vertical-align: top; }
        th { background: #d9d9d9; font-weight: bold; }
        
        .no-data { text-align: center; padding: 20px; color: #666; font-style: italic; }

        .signature-row { display:flex; justify-content:flex-end; align-items:flex-end; margin-top:40px }
        .sign { width:30%; text-align:center }
        .sign .name { font-weight:700; text-decoration:underline; display:block }
        .sign .position { margin-top:4px; font-size:12px }

        .footer { margin-top:30px; font-size:12px }
        .contact { margin-top:20px; font-size:11px; border-top:2px solid #e6e6e6; padding-top:8px; display:flex; justify-content:space-between; align-items:center }
        
        @media print {
            body, html { width:297mm }
            .page { padding:10mm }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header" style="text-align:center;">
            @if($barangayDetails && $barangayDetails->logo1_path)
            <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" class="logo-left" alt="logo left">
            @endif
             @if($barangayDetails && $barangayDetails->logo2_path)
            <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" class="logo-right" alt="logo right">
            @endif
            <div class="gov">REPUBLIC OF THE PHILIPPINES</div>
            <div class="gov">PROVINCE OF {{ strtoupper($barangayDetails->province ?? '') }}</div>
            <div class="gov">MUNICIPALITY OF {{ strtoupper($barangayDetails->city_municipality ?? $barangayDetails->municipality ?? '') }}</div>
            <div class="barangay">BARANGAY {{ strtoupper($barangayDetails->barangay_name ?? $barangayDetails->barangay ?? $barangayDetails->name ?? '') }}</div>
            <div class="office">Office of the Punong Barangay</div>
            <div style="margin-top:12px">
            <hr style="border:none; border-top:2px solid #000; margin:6px auto; width:100%">
            <hr style="border:none; border-top:1px solid #000; margin:0 auto; width:100%">
            </div>
        </div>

        <div class="report-title">KATARUNGANG PAMBARANGAY Case Report</div>
        <div style="text-align:center; margin-bottom:20px; font-size:12px">
            Generated on: {{ now()->format('F j, Y h:i A') }}
        </div>

        <div class="filters">
            <strong style="display:block; margin-bottom:5px">Report Filters:</strong>
            <div class="filter-item"><strong>Date Range:</strong> 
                {{ \Carbon\Carbon::parse($filters['date_from'] ?? now())->format('M d, Y') }} to 
                {{ \Carbon\Carbon::parse($filters['date_to'] ?? now())->format('M d, Y') }}
            </div>
            @if(!empty($filters['nature_of_dispute']))
                <div class="filter-item"><strong>Nature of Dispute:</strong> {{ $filters['nature_of_dispute'] }}</div>
            @endif
            @if(!empty($filters['mode_of_settlement']))
                <div class="filter-item"><strong>Mode of Settlement:</strong> {{ $filters['mode_of_settlement'] }}</div>
            @endif
            @if(!empty($filters['action_taken']))
                <div class="filter-item"><strong>Action Taken:</strong> {{ $filters['action_taken'] }}</div>
            @endif
            <div class="filter-item"><strong>Total Records:</strong> {{ $kpCases->count() }}</div>
        </div>

        @if($kpCases->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">#</th>
                    <th style="width: 80px;">Case No.</th>
                    <th>Complainants</th>
                    <th>Responders</th>
                    <th>Dispute Type</th>
                    <th>Nature</th>
                    <th>Mode</th>
                    <th>Action Taken</th>
                    <th style="width: 70px;">Date Filed</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kpCases as $index => $case)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $case->case_no }}</td>
                    <td>{{ Str::limit($case->complainants, 50) }}</td>
                    <td>{{ Str::limit($case->responders, 50) }}</td>
                    <td>{{ $case->dispute_type }}</td>
                    <td>{{ $case->nature_of_dispute ?? 'N/A' }}</td>
                    <td>{{ $case->mode_of_settlement ?? 'N/A' }}</td>
                    <td>{{ $case->action_taken ?? 'N/A' }}</td>
                    <td>{{ $case->created_at->format('m/d/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="no-data">
            <h3>No Records Found</h3>
            <p>No KP Case records found matching the selected criteria.</p>
        </div>
        @endif

        <div class="signature-row">
            <div class="sign">
                <div style="margin-top:20px">
                    <span class="name">{{ ($barangayDetails && $barangayDetails->captain_name) ?
                     strtoupper($barangayDetails->captain_name) : '________________' }}</span>
                    <div class="position">Punong Barangay</div>
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
