<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay ID - {{ $resident->last_name }}, {{ $resident->first_name }}</title>
    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }
        
        .id-container {
            display: flex;
            flex-direction: row;
            gap: 0.5in;
            justify-content: center;
            align-items: center;
            width: 100vw;
            height: 100vh;
            padding: 0.25in;
            box-sizing: border-box;
        }
        
        .id-card {
            width: 3.5in;
            height: 2.25in;
            border: 2px solid #0066cc;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            flex-shrink: 0;
        }
        
        /* Front Side Styles */
        .front-header {
            background: linear-gradient(135deg, #0066cc 0%, #004499 100%);
            color: white;
            padding: 4px 6px;
            text-align: center;
            font-size: 7px;
            line-height: 1.0;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 45px;
            overflow: hidden;
        }
        
        .front-header-logos {
            width: 28px;
            height: 28px;
            object-fit: contain;
            flex-shrink: 0;
        }
        
        .front-header-text {
            flex: 1;
            font-weight: bold;
            text-transform: uppercase;
            padding: 0 4px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .front-header-text > div {
            margin: 0;
            line-height: 1.0;
        }
        
        .office-info {
            font-size: 5px;
            margin-top: 1px;
            font-style: italic;
        }
        
        .ordinance-info {
            background: rgba(255,255,255,0.2);
            font-size: 5px;
            padding: 1px 3px;
            margin-top: 1px;
            border-radius: 2px;
        }
        
        .front-content {
            padding: 6px;
            display: flex;
            gap: 6px;
            height: calc(100% - 75px);
            position: relative;
        }
        
        .resident-photo {
            width: 55px;
            height: 65px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            overflow: hidden;
            flex-shrink: 0;
            border-radius: 3px;
        }
        
        .resident-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .resident-details {
            flex: 1;
            font-size: 7px;
            line-height: 1.1;
            padding-right: 70px;
        }
        
        .resident-name {
            font-weight: bold;
            font-size: 8px;
            color: #0066cc;
            margin-bottom: 2px;
            text-transform: uppercase;
            line-height: 1.0;
        }
        
        .resident-info {
            margin-bottom: 1px;
            font-size: 6px;
            line-height: 1.1;
        }
        
        .resident-info strong {
            color: #333;
            width: 30px;
            display: inline-block;
            font-size: 6px;
        }
        
        .id-number {
            position: absolute;
            top: 50px;
            right: 6px;
            background: #ff0000;
            color: white;
            padding: 1px 4px;
            font-size: 6px;
            font-weight: bold;
            border-radius: 2px;
            z-index: 10;
        }
        
        .issue-dates {
            position: absolute;
            top: 62px;
            right: 6px;
            font-size: 5px;
            color: #d63333;
            text-align: right;
            background: rgba(255,255,255,0.95);
            padding: 1px 3px;
            border-radius: 2px;
            border: 1px solid #eee;
            z-index: 10;
        }
        
        .front-footer {
            position: absolute;
            bottom: 3px;
            left: 6px;
            right: 6px;
            text-align: center;
            font-size: 5px;
            color: #0066cc;
            font-weight: bold;
            border-top: 1px solid #ddd;
            padding-top: 1px;
        }
        
        .card-title {
            position: absolute;
            bottom: 10px;
            left: 6px;
            right: 6px;
            text-align: center;
            font-size: 6px;
            color: #ff6600;
            font-weight: bold;
            background: rgba(255,255,255,0.95);
            padding: 1px 3px;
            border-radius: 2px;
            border: 1px solid #eee;
        }
        
        /* Back Side Styles */
        .id-card-back {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .back-header {
            background: #333;
            color: white;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
        }
        
        .back-content {
            padding: 6px;
            font-size: 6px;
            line-height: 1.2;
            height: calc(100% - 35px);
            position: relative;
        }
        
        .certification-text {
            margin-bottom: 6px;
            text-align: justify;
            color: #333;
            padding-right: 60px;
            margin-top: 35px;
        }
        
        .note-section {
            margin-bottom: 8px;
            padding: 4px;
            background: rgba(255,255,255,0.7);
            border-radius: 3px;
        }
        
        .note-title {
            font-weight: bold;
            color: #d63333;
        }
        
        .fingerprint-section {
            position: absolute;
            bottom: 35px;
            left: 6px;
            width: 45px;
            height: 30px;
            border: 1px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
        }
        
        .fingerprint-label {
            font-size: 4px;
            text-align: center;
            color: #666;
        }
        
        .emergency-contact {
            position: absolute;
            top: 6px;
            right: 6px;
            font-size: 5px;
            text-align: center;
            color: #d63333;
            background: rgba(255,255,255,0.95);
            padding: 2px;
            border-radius: 2px;
            border: 1px solid #ddd;
            width: 55px;
        }
        
        .emergency-label {
            font-weight: bold;
            font-style: italic;
            color: #d63333;
        }
        
        .signature-section {
            position: absolute;
            bottom: 6px;
            right: 6px;
            text-align: center;
            font-size: 5px;
        }
        
        .signature-image {
            height: 12px;
            margin-bottom: 1px;
        }
        
        .captain-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 1px;
        }
        
        .captain-title {
            font-style: italic;
            color: #666;
        }
        
        .additional-info {
            position: absolute;
            bottom: 18px;
            left: 6px;
            right: 65px;
            font-size: 4px;
            color: #666;
            font-style: italic;
        }
        
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
                box-sizing: border-box !important;
            }
            
            @page {
                size: 11in 8.5in;
                margin: 0.5in;
            }
            
            html, body {
                width: 100% !important;
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
                background: white !important;
            }
            
            .id-container {
                width: 100% !important;
                height: 100% !important;
                display: flex !important;
                flex-direction: row !important;
                justify-content: center !important;
                align-items: center !important;
                gap: 0.75in !important;
                padding: 0.25in !important;
                margin: 0 !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
            
            .id-card {
                width: 3.5in !important;
                height: 2.25in !important;
                flex-shrink: 0 !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                display: block !important;
            }
            
            .front-header {
                background: linear-gradient(135deg, #0066cc 0%, #004499 100%) !important;
                color: white !important;
            }
            
            .back-header {
                background: #333 !important;
                color: white !important;
            }
        }
    </style>
</head>
<body>
    <div class="id-container">
        <!-- Front Side -->
        <div class="id-card">
            <div class="front-header">
                @if($barangayDetails && $barangayDetails->logo1_path)
                    <img src="{{ Storage::url($barangayDetails->logo1_path) }}" class="front-header-logos">
                @endif
                
                <div class="front-header-text">
                    <div>Republic Of The Philippines</div>
                    <div>Province of {{ $barangayDetails->heading1 ?? 'NEGROS OCCIDENTAL' }}</div>
                    <div>Municipality of {{ $barangayDetails->heading2 ?? 'HINOBA-AN' }}</div>
                    <div style="font-size: 8px; margin-top: 1px;">{{ $barangayDetails->heading4 ?? 'BARANGAY BACUYANGAN' }}</div>
                    @if($barangayDetails && $barangayDetails->office_info)
                        <div class="office-info">{{ $barangayDetails->office_info }}</div>
                    @endif
                    @if($barangayDetails && $barangayDetails->ordinance_info)
                        <div class="ordinance-info">{{ $barangayDetails->ordinance_info }}</div>
                    @endif
                </div>
                
                @if($barangayDetails && $barangayDetails->logo2_path)
                    <img src="{{ Storage::url($barangayDetails->logo2_path) }}" class="front-header-logos">
                @endif
            </div>
            
            <div class="front-content">
                <div class="resident-photo">
                    @if($resident->profile_picture)
                        <img src="{{ asset('storage/public/profile_pictures/' . basename($resident->profile_picture)) }}" alt="Profile Picture">
                    @else
                        <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #666;">
                            <span style="font-size: 10px;">No Photo</span>
                        </div>
                    @endif
                </div>
                
                <div class="resident-details">
                    <div class="resident-name">{{ $fullName ?? ($resident->first_name . ' ' . $resident->last_name) }}</div>
                    <div class="resident-info">Zone 3, Brgy. {{ $resident->purok->purok_name ?? 'Bacuyangan' }}, Hinoba-an, Neg. Occ.</div>
                    <div class="resident-info"><strong>Sex:</strong> {{ strtoupper($resident->sex ?? '') }}</div>
                    <div class="resident-info"><strong>Civil Status:</strong> {{ strtoupper($resident->civil_status ?? '') }}</div>
                    <div class="resident-info"><strong>Date of Birth:</strong> {{ strtoupper(date('M j, Y', strtotime($resident->birth_date ?? now()))) }}</div>
                    <div class="resident-info"><strong>Date Issued:</strong> {{ strtoupper(date('m/d/Y')) }}</div>
                    <div class="resident-info"><strong>Expiration Date:</strong> {{ strtoupper(date('m/d/Y', strtotime('+' . ($barangayDetails->validity_years ?? 3) . ' years'))) }}</div>
                </div>
            </div>
            
            <div class="id-number">
                ID No: {{ $resident->household_number ?? 'MHBB-' . date('Y') . '-' . str_pad($resident->id ?? '0000', 4, '0', STR_PAD_LEFT) }}
            </div>
            
            <div class="issue-dates">
                <div>Date Issued: {{ date('m/d/Y') }}</div>
                <div>Expiration: {{ date('m/d/Y', strtotime('+' . ($barangayDetails->validity_years ?? 3) . ' years')) }}</div>
            </div>
            
            @if($barangayDetails && $barangayDetails->footer_text)
                <div class="front-footer">
                    {{ $barangayDetails->footer_text }}
                </div>
            @endif
            
            @if($barangayDetails && $barangayDetails->card_title)
                <div class="card-title">
                    {{ $barangayDetails->card_title }}
                </div>
            @endif
        </div>

        <!-- Back Side -->
        <div class="id-card id-card-back">
            <div class="back-header">
                {{ $barangayDetails->back_header ?? 'THIS CARD IS NON-TRANSFERABLE' }}
            </div>
            
            <div class="back-content">
                @if($barangayDetails && $barangayDetails->emergency_contact_name)
                    <div class="emergency-contact">
                        <div class="emergency-label">In case of EMERGENCY please notify:</div>
                        <div style="margin-top: 2px;">
                            <div style="font-weight: bold;">{{ $barangayDetails->emergency_contact_name }}</div>
                            <div>{{ $barangayDetails->emergency_contact_number }}</div>
                            <div style="font-size: 5px; margin-top: 1px;">{{ $barangayDetails->emergency_contact_address }}</div>
                        </div>
                    </div>
                @endif
                
                <div class="certification-text">
                    {{ $barangayDetails->back_certification ?? 'This certifies that the person whose name and picture appear on the reverse side of this card is a bonafide resident of BARANGAY BACUYANGAN, MUNICIPALITY OF HINOBA-AN, NEGROS OCCIDENTAL.' }}
                </div>
                
                @if($barangayDetails && $barangayDetails->back_note)
                    <div class="note-section">
                        <div class="note-title">NOTE:</div>
                        <div style="white-space: pre-line;">{{ $barangayDetails->back_note }}</div>
                    </div>
                @endif
                
                @if(($barangayDetails->include_fingerprint ?? true))
                    <div class="fingerprint-section">
                        <div class="fingerprint-label">
                            Right Thumb Print
                        </div>
                    </div>
                @endif
                
                <div class="signature-section">
                    @if($barangayDetails && $barangayDetails->signature_path)
                        <img src="{{ Storage::url($barangayDetails->signature_path) }}" class="signature-image">
                    @endif
                    <div class="captain-name">{{ $barangayDetails->pass_captain ?? 'NOEL R. LAYDA' }}</div>
                    <div class="captain-title">Punong Barangay</div>
                </div>
                
                @if($barangayDetails && $barangayDetails->back_loss_info)
                    <div class="additional-info">
                        {{ $barangayDetails->back_loss_info }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            // Small delay to ensure CSS is loaded
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>