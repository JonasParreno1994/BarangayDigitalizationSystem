<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay ID - {{ $resident->last_name }}, {{ $resident->first_name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: white;
            margin: 0;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .id-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .id-card {
            width: 3.5in;
            height: 2.25in;
            border: 2px solid #1a365d;
            border-radius: 15px;
            padding: 15px;
            position: relative;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            background: linear-gradient(to bottom right, #ffffff, #f0f4f8);
        }
        
        .id-header {
            background-color: #1a365d;
            color: white;
            padding: 8px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            margin: -15px -15px 15px -15px;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .id-header-text {
            flex: 1;
            text-align: center;
        }
        
        .id-header-logo {
            height: 25px;
            margin: 0 5px;
        }
        
        .id-content {
            display: flex;
            gap: 15px;
        }
        
        .id-photo {
            width: 1in;
            height: 1.25in;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .id-photo img {
            max-width: 100%;
            max-height: 100%;
        }
        
        .id-details {
            flex: 1;
            font-size: 10px;
            line-height: 1.4;
        }
        
        .id-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
            color: #1a365d;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
        }
        
        .id-field {
            margin-bottom: 2px;
            display: flex;
        }
        
        .id-label {
            font-weight: bold;
            width: 70px;
            color: #555;
            flex-shrink: 0;
        }
        
        .id-value {
            color: #333;
        }
        
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
                <div class="id-field"><span class="id-label">Address:</span> <span class="id-value">{{ $address }}</span></div>
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