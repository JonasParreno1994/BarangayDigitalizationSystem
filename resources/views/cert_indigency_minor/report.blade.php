<!DOCTYPE html>
<html>
<head>
    <title>Released Certificates Report</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background-color: #f9f9f9; 
            color: #333; 
        }
        h2 { 
            text-align: center; 
            color: #4CAF50; 
        }
        p { 
            text-align: center; 
            font-size: 1.1em; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            background-color: #fff; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        }
        table, th, td { 
            border: 1px solid #ddd; 
        }
        th { 
            background-color: #4CAF50; 
            color: white; 
            padding: 10px; 
            text-align: center; 
        }
        td { 
            padding: 10px; 
            text-align: left; 
        }
        tr:nth-child(even) { 
            background-color: #f2f2f2; 
        }
        tr:hover { 
            background-color: #f1f1f1; 
        }
        button { 
            display: block; 
            margin: 20px auto; 
            padding: 10px 20px; 
            background-color: #4CAF50; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-size: 1em; 
        }
        button:hover { 
            background-color: #45a049; 
        }
        @media print {
            @page { 
                size: A4; 
                margin: 20mm; 
            }
            button { 
                display: none; 
            }
            body { 
                margin: 0; 
            }
        }
    </style>
</head>
<body>
    <h2>Released Certificates of Indigency to Minor Report</h2>
    <p><strong>From:</strong> {{ \Carbon\Carbon::parse($dateFrom)->format('F d, Y') }} <strong>To:</strong> {{ \Carbon\Carbon::parse($dateTo)->format('F d, Y') }}</p>
    <p><strong>Total Records:</strong> {{ $reportData->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Resident Name</th>
                <th>Date of Issuance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $record->resident->full_name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->date_of_issuance)->format('F d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button onclick="window.print()">🖨 Print</button>
</body>
</html>
