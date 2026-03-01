<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=794px">
    <title>KP Case - {{ $kpCase->case_no }}</title>
    <style>
        @page { size: A4; margin: 12mm; }
        body { font-family: 'Times New Roman', Times, serif; margin:0; padding:0; background:#fff; color:#000 }
        .page { width:210mm; margin:0 auto; padding:20mm 18mm; box-sizing:border-box }
        .header { position:relative; text-align:center; padding-bottom:8px; padding-left:110px; background: linear-gradient(135deg, #00b894 0%, #fdcb6e 50%, #0984e3 100%) }
        .logo-left { position:absolute; left:18mm; top:.05mm; width:100px; height:100px; object-fit:contain }
        .logo-right { position:absolute; right:18mm; top:.05mm; width:90px; height:90px; object-fit:contain }
        .header .gov { font-weight:700;font-family: Calisto MT; font-size:13px; margin:2px 0 }
        .header .barangay { font-weight:900; font-size:20px; margin:4px 0; color:#0b5ed7 }
        .office { font-weight:700; font-style:italic; font-size:14px; color:#0b5ed7 }
        .title { text-align:center; font-size:26px; font-weight:700; margin:18px 0 8px }
        .subtitle { text-align:center; font-size:18px; font-weight:700; margin:0 0 20px }
        .content { font-size:16px;font-family: 'Times New Roman', Times, serif; text-align:justify; margin:6px 0; line-height:1.6 }
        .content table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .content table td { padding: 8px; vertical-align: top; }
        .content table td:first-child { font-weight: bold; width: 180px; }
        .signature-row { display:flex; justify-content:flex-end; align-items:flex-end; margin-top:50px }
        .sign { width:45%; text-align:center }
        .sign .name { font-weight:700; text-decoration:underline; display:block }
        .sign .position { margin-top:4px; font-size:14px }
        .footer { margin-top:40px; font-size:12px }
        .contact { margin-top:24px; font-size:12px; border-top:2px solid #e6e6e6; padding-top:8px; display:flex; justify-content:space-between; align-items:center }
        .contact .left { font-size:12px }
        .contact .right { font-size:12px }
        @media print {
            body, html { width:210mm }
            .page { padding:12mm }
        }
    </style>
</head>
<body>
    <div class="page">
        @include('components.cer_header')

        <div class="title">KATARUNGANG PAMBARANGAY</div>
        <div class="subtitle">CASE REPORT</div>

        <div class="content">
            <table>
                <tr>
                    <td>Barangay Case No.:</td>
                    <td>{{ $kpCase->case_no }}</td>
                </tr>
                <tr>
                    <td>Nature of Dispute:</td>
                    <td>{{ $kpCase->nature_of_dispute }}</td>
                </tr>
                <tr>
                    <td>Complainants:</td>
                    <td>{!! nl2br(e($kpCase->complainants)) !!}</td>
                </tr>
                <tr>
                    <td>Responders:</td>
                    <td>{!! nl2br(e($kpCase->responders)) !!}</td>
                </tr>
                <tr>
                    <td>Dispute Type:</td>
                    <td>{{ $kpCase->dispute_type }}</td>
                </tr>
                <tr>
                    <td>Mode of Settlement:</td>
                    <td>{{ $kpCase->mode_of_settlement }}</td>
                </tr>
                <tr>
                    <td>Action Taken:</td>
                    <td>{{ $kpCase->action_taken }}</td>
                </tr>
            </table>

            <p style="margin-top: 30px;">
                This certification is issued for whatever legal purpose it may serve.
            </p>

            <p>
                Issued this <strong>{{ now()->format('jS') }}</strong> day of
                <strong>{{ now()->format('F') }}, {{ now()->format('Y') }}</strong>
                at Barangay {{ ucfirst(strtolower($barangayDetails->barangay_name ?? $barangayDetails->barangay ?? 'Barangay')) }} Administration Center.
            </p>
        </div>

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
        window.onload = function(){ window.print(); }
        window.onafterprint = function(){ window.close(); window.history.back(); };
    </script>
</body>
</html>
