<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KATARUNGANG PAMBARANGAY COMPLIANCE REPORT</title>
    <style>
        @page { size: A4 landscape; margin: 10mm; }
        body { font-family: Arial, sans-serif; font-size: 10px; margin: 0; padding: 0; }
        .container { width: 100%; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; font-family: 'Times New Roman', Times, serif; position: relative; }
        .header p { margin: 2px 0; font-weight: bold; font-size: 12px; }
        .header h3 { margin: 5px 0; text-transform: uppercase; font-size: 14px; }
        .logo-left { position:absolute; left: 17%; top:0; width:80px; height:80px; object-fit:contain; }
        .logo-right { position:absolute; right:17%; top:0; width:80px; height:80px; object-fit:contain; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; vertical-align: middle; word-wrap: break-word; }
        th { background-color: #e0e0e0; font-weight: bold; font-size: 10px; }
        
        .col-case-no { width: 6%; }
        .col-name { width: 12%; }
        .col-dispute { width: 12%; }
        .col-nature { width: 4%; }
        .col-settlement { width: 4%; }
        .col-action { width: 4%; }
        
        .total-row td { font-weight: bold; background-color: #f9f9f9; }
        .yellow-bg { background-color: #ffff00; }
        
        .footer { margin-top: 30px; display: flex; justify-content: space-between; page-break-inside: avoid; }
        .prepared-by, .certified-by { width: 40%; }
        
        @media print {
            .no-print { display: none; }
             /* Force background colors */
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($barangayDetails && $barangayDetails->logo1_path)
            <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" class="logo-left" alt="logo left">
            @endif
             @if($barangayDetails && $barangayDetails->logo2_path)
            <img src="{{ asset('storage/' . $barangayDetails->logo2_path) }}" class="logo-right" alt="logo right">
            @endif
            <p>PROVINCE OF {{ strtoupper($barangayDetails->province ?? '') }}</p>
            <p>MUNICIPALITY OF {{ strtoupper($barangayDetails->city_municipality ?? $barangayDetails->municipality ?? '') }}</p>
            <p>BARANGAY {{ strtoupper($barangayDetails->barangay_name ?? $barangayDetails->barangay ?? $barangayDetails->name ?? '') }}</p>
            <h3>KATARUNGANG PAMBARANGAY COMPLIANCE REPORT</h3>
            <p>{{ strtoupper(\Carbon\Carbon::parse($dateFrom)->format('F')) }} TO {{ strtoupper(\Carbon\Carbon::parse($dateTo)->format('F Y')) }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="3" class="col-case-no">Barangay Case No.</th>
                    <th rowspan="3" class="col-name">Name of Complainant/s</th>
                    <th rowspan="3" class="col-name">Name of Respondent/s</th>
                    <th rowspan="3" class="col-dispute">Name/Type of Dispute</th>
                    <th colspan="4">Nature of Disputes</th>
                    <th colspan="9">ACTION TAKEN</th>
                </tr>
                <tr>
                    <th rowspan="2" class="col-nature">Criminal</th>
                    <th rowspan="2" class="col-nature">Civil</th>
                    <th rowspan="2" class="col-nature">Others</th>
                    <th rowspan="2" class="col-nature">Total</th>
                    <th colspan="3">Mode of Settlement</th>
                    <th colspan="6">Other Actions Taken</th>
                </tr>
                <tr>
                    <th class="col-settlement">Mediation</th>
                    <th class="col-settlement">Conciliation</th>
                    <th class="col-settlement">Arbitration</th>
                    <th class="col-action">Repudiated</th>
                    <th class="col-action">Withdrawn</th>
                    <th class="col-action">Pending</th>
                    <th class="col-action">Dismissed</th>
                    <th class="col-action">Certified to File Action</th>
                    <th class="col-action">Referred to concerned agencies</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kpCases as $case)
                <tr>
                    <td>{{ $case->case_no }}</td>
                    <td style="text-align: left;">{{ $case->complainants }}</td>
                    <td style="text-align: left;">{{ $case->responders }}</td>
                    <td>{{ $case->dispute_type }}</td>
                    <td>{{ $case->nature_of_dispute == 'Criminal' ? '1' : '' }}</td>
                    <td>{{ $case->nature_of_dispute == 'Civil' ? '1' : '' }}</td>
                    <td>{{ $case->nature_of_dispute == 'Others' ? '1' : '' }}</td>
                    <td>1</td>
                    <td>{{ $case->mode_of_settlement == 'Mediation' ? '1' : '' }}</td>
                    <td>{{ $case->mode_of_settlement == 'Conciliation' ? '1' : '' }}</td>
                    <td>{{ $case->mode_of_settlement == 'Arbitration' ? '1' : '' }}</td>
                    <td>{{ $case->action_taken == 'Repudiated' ? '1' : '' }}</td>
                    <td>{{ $case->action_taken == 'Withdrawn' ? '1' : '' }}</td>
                    <td>{{ $case->action_taken == 'Pending' ? '1' : '' }}</td>
                    <td>{{ $case->action_taken == 'Dismissed' ? '1' : '' }}</td>
                    <td>{{ $case->action_taken == 'Certified to file action' ? '1' : '' }}</td>
                    <td>{{ $case->action_taken == 'Referred to concerned agencies' ? '1' : '' }}</td>
                </tr>
                @endforeach
                <tr class="total-row yellow-bg">
                    <td colspan="4" style="text-align: center;">TOTAL</td>
                    <td>{{ $totals['nature_criminal'] }}</td>
                    <td>{{ $totals['nature_civil'] }}</td>
                    <td>{{ $totals['nature_others'] }}</td>
                    <td>{{ $totals['nature_total'] }}</td>
                    <td>{{ $totals['settled_mediation'] }}</td>
                    <td>{{ $totals['settled_conciliation'] }}</td>
                    <td>{{ $totals['settled_arbitration'] }}</td>
                    <td>{{ $totals['action_repudiated'] }}</td>
                    <td>{{ $totals['action_withdrawn'] }}</td>
                    <td>{{ $totals['action_pending'] }}</td>
                    <td>{{ $totals['action_dismissed'] }}</td>
                    <td>{{ $totals['action_certified'] }}</td>
                    <td>{{ $totals['action_referred'] }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <div class="prepared-by">
                <p>PREPARED & SUBMITTED BY:</p>
                <br><br>
                <p style="text-decoration: underline; font-weight: bold;">{{ strtoupper($secretaryName) }}</p>
                <p>Barangay/Lupon Secretary</p>
            </div>
            <div class="certified-by" style="text-align: right;">
                <p>CERTIFIED CORRECT:</p>
                <br><br>
                <p style="text-decoration: underline; font-weight: bold;">{{ strtoupper($captainName) }}</p>
                <p>Punong Barangay</p>
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
