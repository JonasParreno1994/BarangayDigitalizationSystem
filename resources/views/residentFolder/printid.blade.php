<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay ID - {{ $resident->last_name }}, {{ $resident->first_name }}</title>
    <style>
        /* Hide any debug or unwanted content */
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
                    <div>Province of {{ $barangayDetails->heading1 }}</div>
                    <div>Municipality of {{ $barangayDetails->heading2}}</div>
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
                    <div class="resident-name">{{ $fullName }}</div>
                    <div class="resident-info">Zone 3, Brgy. {{ $resident->purok->purok_name ?? 'Bacuyangan' }}, Hinoba-an, Neg. Occ.</div>
                    <div class="resident-info"><strong>Sex:</strong> {{ strtoupper($resident->sex) }}</div>
                    <div class="resident-info"><strong>Civil Status:</strong> {{ strtoupper($resident->civil_status) }}</div>
                    <div class="resident-info"><strong>Date of Birth:</strong> {{ strtoupper(date('M j, Y', strtotime($resident->birth_date))) }}</div>
                    <div class="resident-info"><strong>Date Issued:</strong> {{ strtoupper(date('m/d/Y')) }}</div>
                    <div class="resident-info"><strong>Expiration Date:</strong> {{ strtoupper(date('m/d/Y', strtotime('+' . ($barangayDetails->validity_years ?? 3) . ' years'))) }}</div>
                </div>
            </div>
            
            <div class="id-number">
                ID No: {{ $resident->household_number ?? 'MHBB-' . date('Y') . '-' . str_pad($resident->id, 4, '0', STR_PAD_LEFT) }}
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
        
        .id-footer {
            position: absolute;
            bottom: 10px;
            right: 15px;
            font-size: 8px;
            color: #777;
            text-align: right;
        }
        
        .id-number {
            position: absolute;
            top: 50px;
            right: 15px;
            font-size: 10px;
            color: #1a365d;
            font-weight: bold;
            background-color: rgba(255,255,255,0.7);
            padding: 2px 5px;
            border-radius: 3px;
        }
        
        .id-qr {
            position: absolute;
            bottom: 10px;
            left: 15px;
            width: 0.6in;
            height: 0.6in;
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
        }
        
        .id-signature {
            position: absolute;
            bottom: 30px;
            width: calc(100% - 30px);
            text-align: center;
            font-size: 8px;
            border-top: 1px dashed #ccc;
            padding-top: 3px;
        }
        
        .id-signature-image {
            height: 20px;
            margin-top: 2px;
        }
        
        .id-validity {
            position: absolute;
            top: 70px;
            right: 15px;
            font-size: 8px;
            color: #d63333;
            font-weight: bold;
            background-color: rgba(255,255,255,0.7);
            padding: 2px 5px;
            border-radius: 3px;
        }
        
        .id-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 40px;
            font-weight: bold;
            color: rgba(26, 54, 93, 0.1);
            z-index: 0;
            pointer-events: none;
            user-select: none;
        }
        
        /* Back side styles */
        .id-card-back {
            background: linear-gradient(to bottom right, #f8f9fa, #e9ecef);
        }
        
        .back-header {
            background-color: #1a365d;
            color: white;
            padding: 8px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            margin: -15px -15px 15px -15px;
            font-weight: bold;
            font-size: 14px;
        }
        
        .back-content {
            padding: 10px;
            font-size: 8px;
            line-height: 1.4;
        }
        
        .back-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            font-size: 10px;
            color: #1a365d;
        }
        
        .back-text {
            margin-bottom: 8px;
            text-align: justify;
        }
        
        .back-contact {
            margin-top: 15px;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
        }
        
        .back-stamp {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            width: 1in;
            height: 0.5in;
            border: 1px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7px;
            text-align: center;
        }
        
        .back-qr-large {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 1in;
            height: 1in;
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
        }
        
       @media print {
        * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        .id-header {
            background-color: #1a365d !important;
            color: white !important;
        }
        
        .id-card {
            background: linear-gradient(to bottom right, #ffffff, #f0f4f8) !important;
        }
        
        .id-card-back {
            background: linear-gradient(to bottom right, #f8f9fa, #e9ecef) !important;
        }
    }
    </style>
</head>
<body>
    <div class="id-container">
        <!-- Front Side (Top) -->
        <div class="id-card">

            <div class="id-header">
            @if($barangayDetails->logo1_path ?? false)
                <img src="{{ Storage::url($barangayDetails->logo1_path) }}" class="id-header-logo">
            @endif
            <div class="id-header-text">
                {{ $barangayDetails->heading1 ?? 'REPUBLIC OF THE PHILIPPINES' }}<br>
                {{ $barangayDetails->heading2 ?? 'PROVINCE OF' }}<br>
                {{ $barangayDetails->heading3 ?? 'BARANGAY' }}
            </div>
            @if($barangayDetails->logo2_path ?? false)
                <img src="{{ Storage::url($barangayDetails->logo2_path) }}" class="id-header-logo">
            @endif
            </div>
            
            <div class="id-content" style="width:100%;">
            <div class="id-photo">
                @if($resident->profile_picture)
                <img src="{{ asset('storage/public/profile_pictures/' . basename($resident->profile_picture)) }}" alt="Profile Picture" style="width:100%;height:100%;object-fit:cover;">
                @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                @endif
            </div>
            
            <div class="id-details">
                <div class="id-name">{{ $fullName }}</div>
               <div class="id-field"><span class="id-label">Address:</span> <span class="id-value">{{ $resident->purok->purok_name ?? 'N/A' }}</span></div>
                <div class="id-field"><span class="id-label">Birthdate:</span> <span class="id-value">{{ date('m/d/Y', strtotime($resident->birth_date)) }} ({{ $age }} yrs)</span></div>
                <div class="id-field"><span class="id-label">Gender:</span> <span class="id-value">{{ $resident->sex }}</span></div>
                <div class="id-field"><span class="id-label">Status:</span> <span class="id-value">{{ $resident->civil_status }}</span></div>
                <div class="id-field"><span class="id-label">Voter:</span> <span class="id-value">{{ $resident->voter_status }}</span></div>
            </div>

            <div style="display: flex; flex-direction: column; align-items: flex-end; justify-content: flex-start;">
                @if($qrCode)
                <div class="id-qr" style="position: static; margin-bottom: 10px;">
                    {!! $qrCode !!}
                </div>
                @else
                <div class="id-qr" style="position: static; margin-bottom: 10px;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#1a365d" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    </svg>
                </div>
                @endif
            </div>
            </div>
            
            <div class="id-number">ID: {{ $resident->household_number }}</div>
            <div class="id-validity">VALID FOR: {{ $item->validity ?? '3 YEARS' }}</div>
            
            <div class="id-footer">
            Issued: {{ date('m/d/Y') }}<br>
            Valid until: {{ date('m/d/Y', strtotime('+'.($item->validity ?? '3 years'))) }}
            </div>
        </div>

        <!-- Back Side (Bottom) -->
        <div class="id-card id-card-back">
            <div class="back-header">
            {{ $barangayDetails->heading3 ?? 'BARANGAY IDENTIFICATION CARD' }}
            </div>
            
            <div class="back-content">
            <div class="back-title">OFFICIAL BARANGAY ID</div>
            
            <div class="back-text">
                This is to certify that the bearer is a bonafide resident of {{ $items->heading3 ?? 'THIS BARANGAY' }}. 
                This ID is non-transferable and must be presented when availing of barangay services.
            </div>
            
            <div class="back-text">
                <strong>Conditions:</strong><br>
                1. Valid for {{ $barangayDetails->validity ?? '3 years' }} from date of issue<br>
                2. Must be surrendered when moving out of the barangay<br>
                3. Report lost ID immediately to barangay office<br>
                4. Replacement fee: ₱{{ $barangayDetails->replacement_fee ?? '100' }}
            </div>

            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 20px;">

                <div class="back-contact" style="text-align: left;">
                    BARANGAY HALL: {{ $barangayDetails->barangay_contact ?? '(123) 456-7890' }}<br>
                    EMERGENCY: {{ $barangayDetails->emergency_contact ?? '911' }}
                </div>

                <div class="id-signature" style="text-align: right;">
                    @if($barangayDetails->signature_path ?? false)
                        <img src="{{ asset('storage/'.$barangayDetails->signature_path) }}" class="id-signature-image">
                    @endif
                    <div>{{ $barangayDetails->pass_captain ?? 'BARANGAY CAPTAIN' }}</div>
                    <div>Barangay Captain</div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
                setTimeout(function() {
                    window.close();
                }, 500);
            }, 200);
        };
    </script>
</body>
</html>