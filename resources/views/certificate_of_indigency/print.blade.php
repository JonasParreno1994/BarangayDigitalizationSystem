<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=210mm">
    <title>Certificate of Indigency - {{ $certificate->resident->full_name ?? 'Resident' }}</title>
    <style>
        @page {
            size: A4;
            margin: 0 12mm 12mm 12mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            background: #fafafa;
            color: #000
        }

        /* emulate admin "panel" on light gray background */
        .page {
            display: flex;
            flex-direction: column;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 0 18mm 20mm 18mm;
            box-sizing: border-box;
            background: #fff;
            border-radius: .375rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1)
        }

        .header {
            position: relative;
            text-align: center;
            padding-bottom: 1px;
            padding-left: 110px;
        }

        .logo-left {
            position: absolute;
            left: 18mm;
            top: .05mm;
            width: 100px;
            height: 100px;
            object-fit: contain
        }

        .logo-right {
            position: absolute;
            right: 18mm;
            top: .05mm;
            width: 90px;
            height: 90px;
            object-fit: contain
        }

        .header .gov {
            font-weight: 700;
            font-family: Calisto MT;
            font-size: 13px;
            margin: 2px 0
        }

        .header .barangay {
            font-weight: 900;
            font-size: 20px;
            margin: 4px 0;
            color: #0b5ed7
        }

        .office {
            font-weight: 700;
            font-style: italic;
            font-size: 14px;
            color: #0b5ed7
        }

        .title {
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            margin: 18px 0 8px
        }

        .to-whom {
            font-style: italic;
            margin-bottom: 6px
        }

        .content {
            font-size: 20px;
            font-family: 'Times New Roman', Times, serif;
            text-align: justify;
            margin: 6px 0;
            line-height: 2
        }

        .content p {
            text-indent: 0.6in;
            margin: 10px 0
        }

        .signature-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 50px
        }

        .applicant {
            width: 45%;
            text-align: left
        }

        .applicant .name {
            font-weight: 700;
            text-decoration: underline
        }

        .sign {
            width: 45%;
            text-align: center
        }

        .sign .name {
            font-weight: 700;
            text-decoration: underline;
            display: block
        }

        .sign .position {
            margin-top: 4px;
            font-size: 14px
        }

        .footer {
            margin-top: 40px;
            font-size: 12px
        }

        .receipt {
            margin-top: 18px
        }

        .contact {
            margin-top: auto;
            font-size: 12px;
            border-top: 2px solid #e6e6e6;
            padding-top: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .contact .left {
            font-size: 12px
        }

        .contact .right {
            font-size: 12px
        }

        @media print {

            body,
            html {
                width: 210mm;
                height: 297mm;
            }

            .page {
                padding: 0 12mm 12mm 12mm;
            }

            /* hide common app UI elements when printing (if present) */
            .navbar,
            .topbar,
            .breadcrumb,
            .print-header,
            .no-print {
                display: none !important;
            }

            /* Note: browser-added headers/footers (date, URL, title) are controlled by
               the browser print dialog. Disable "Headers and footers" in print settings
               to remove the timestamp and URL from the printed output. */
        }
    </style>
</head>

<body>
    <div class="page">
        @include('components.cer_header')

        <div class="title">CERTIFICATE OF INDIGENCY</div>
        <div style="margin-bottom: 30px;"></div>
        <div class="to-whom">TO WHOM IT MAY CONCERN:</div>

        <div style="margin-bottom: 30px;"></div>

        <div class="content">
            <p>
                This is to certify that <strong
                    class="name">{{ strtoupper($certificate->resident->full_name ?? '__________') }}</strong>
                of legal age,
                {{ ucfirst(strtolower($certificate->resident->sex ?? '')) }},
                {{ ucfirst(strtolower($certificate->resident->citizenship ?? '')) }}, is a bonafide resident of Purok
                {{ ucfirst(strtolower($certificate->resident->purok->purok_name ?? '__________')) }}, Barangay
                {{ ucfirst(strtolower($barangayDetails->barangay_name ?? $barangayDetails->barangay ?? '')) }},
                {{ ucfirst(strtolower($barangayDetails->city_municipality ?? $barangayDetails->municipality ?? '')) }},
                {{ ucfirst(strtolower($barangayDetails->province ?? '')) }}.
            </p>

            <p>
                Further certifies that the above-named person is a low income and considered as an indigent family which could hardly meet
                family basic needs. 
            </p>
              <p>
                This certification is issued upon the request of the above-named person for whatever
                legal purpose it may serve best. 
            </p>
            <p>
                Issued and signed this <strong>{{ $certificate->date_of_issuance->format('jS') }}</strong> day of
                <strong>{{ $certificate->date_of_issuance->format('F') }},
                    {{ $certificate->date_of_issuance->format('Y') }}</strong>
                at Barangay
                {{ ucfirst(strtolower($barangayDetails->barangay_name ?? $barangayDetails->barangay ?? 'Barangay')) }}, Hinoba-an, Negros Occidental.
            </p>
        </div>

        <div class="signature-row">
            <div class="sign" style="text-align: right; width: 100%;">
                <div style="margin-top:20px">
                    <span class="name" style="text-align: right; width: 100%;">{{ ($barangayDetails && $barangayDetails->captain_name) ?
                        strtoupper($barangayDetails->captain_name) : ''}}</span>
                    <div class="position">Punong Barangay</div>
                </div>
            </div>
        </div>

        @include('components.cer_footer')
        </div>

    <script>
        window.onload = function () { window.print(); }
        window.onafterprint = function () { window.close(); window.history.back(); };
    </script>
</body>

</html>