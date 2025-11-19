<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay ID - Enhanced Design</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .id-container {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .id-card {
            width: 3.5in;
            height: 2.25in;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            position: relative;
            border: 1px solid #e0e0e0;
        }

        /* FRONT SIDE */
        .id-card-front .header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #1e3c72 100%);
            padding: 8px 12px;
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            min-height: 65px;
        }

        .header-logo {
            width: 42px;
            height: 42px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header-logo img {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }

        .header-text {
            flex: 1;
            color: white;
            text-align: center;
            line-height: 1;
        }

        .header-text h1 {
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header-text h2 {
            font-size: 7.5px;
            font-weight: 500;
            margin-top: 1px;
            opacity: 0.95;
        }

        .header-text h3 {
            font-size: 10px;
            font-weight: 700;
            margin-top: 3px;
            letter-spacing: 0.8px;
        }

        .header-subtitle {
            font-size: 6px;
            margin-top: 2px;
            opacity: 0.85;
            font-style: italic;
        }

        .ornament-line {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent 0%, rgba(255, 215, 0, 0.8) 20%, rgba(255, 215, 0, 1) 50%, rgba(255, 215, 0, 0.8) 80%, transparent 100%);
        }

        .content-area {
            padding: 10px 12px;
            display: flex;
            gap: 10px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .photo-container {
            position: relative;
        }

        .photo-frame {
            width: 70px;
            height: 85px;
            border: 2px solid #1e3c72;
            border-radius: 6px;
            overflow: hidden;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-frame::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 4px;
            pointer-events: none;
        }

        .id-number-badge {
            position: absolute;
            bottom: 10px;
            left: 14%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 6.5px;
            font-weight: 700;
            white-space: nowrap;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            border: 1.5px solid white;
            letter-spacing: 0.3px;
        }

        .info-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .resident-name {
            font-size: 11px;
            font-weight: 700;
            color: #1e3c72;
            text-transform: uppercase;
            line-height: 1.2;
            margin-bottom: 4px;
            letter-spacing: 0.3px;
        }

        .address-line {
            font-size: 6.5px;
            color: #444;
            margin-bottom: 6px;
            line-height: 1.3;
            padding: 3px 6px;
            background: rgba(30, 60, 114, 0.05);
            border-radius: 3px;
            border-left: 2px solid #1e3c72;
        }

        .info-grid {
            display: grid;
            gap: 1px;
        }

        .info-row {
            display: grid;
            grid-template-columns: 65px 1fr;
            font-size: 7px;
            line-height: 1;
            padding: 2px 0;
        }

        .info-label {
            font-weight: 600;
            color: #666;
        }

        .info-value {
            color: #222;
            font-weight: 500;
        }

        .validity-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            /* Two equal columns */
            gap: 6px;
            /* space between columns */
            margin-top: 4px;
        }

        .validity-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #fbbf24;
            border-radius: 4px;
            padding: 2px 6px;
            font-size: 6px;
            line-height: 1.3;
        }

        .validity-row {
            display: flex;
            font-size: 6px;
            line-height: 1.3;
        }

        .validity-label {
            font-weight: 600;
            color: #92400e;
        }

        .validity-date {
            font-weight: 700;
            color: #b45309;
        }

       
        .signature-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 60px;
            margin-left: 15px;
            margin-top: 9px;
            
            margin-bottom: -6px;
            
        }

        .signature-img {
            width: 80px;
            height: auto;
            margin-bottom: 1px;
            object-fit: contain;
        }

        .signature-underline {
            width: 100%;
            border-bottom: 0.6px solid #92400e;
        }

        .card-type-badge {
            position: absolute;
            bottom: 132px;
            left: 12px;
            right: 12px;
            text-align: center;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 7px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 6px rgba(249, 115, 22, 0.4);
        }

        /* BACK SIDE */
        .id-card-back .back-header {
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
            padding: 10px;
            text-align: center;
        }

        .back-header h2 {
            color: white;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .back-content {
            padding: 10px 12px;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            height: calc(100% - 44px);
            position: relative;
        }

        .emergency-box {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 1.5px solid #dc2626;
            border-radius: 6px;
            padding: 4px;
            margin-bottom: 3px;
        }

        .emergency-title {
            font-size: 6px;
            font-weight: 700;
            color: #991b1b;
            text-transform: uppercase;
            margin-bottom: 3px;
            text-align: center;
        }

        .emergency-info {
            font-size: 7px;
            color: #7f1d1d;
            text-align: center;
            line-height: 1.4;
        }

        .emergency-name {
            font-weight: 700;
            font-size: 8px;
            margin: 2px 0;
        }

        .certification {
            font-size: 7px;
            line-height: 1.5;
            color: #374151;
            text-align: justify;
            margin-bottom: 8px;
            padding: 6px;
            background: white;
            border-radius: 4px;
            border-left: 3px solid #1e3c72;
        }

        .notes-box {
            background: #fff7ed;
            border: 1px solid #fb923c;
            border-radius: 4px;
            padding: 5px;
            margin-bottom: 6px;
        }

        .notes-title {
            font-size: 6.5px;
            font-weight: 700;
            color: #c2410c;
            margin-bottom: 2px;
        }

        .notes-text {
            font-size: 6px;
            line-height: 1.4;
            color: #7c2d12;
        }

        .bottom-section {
            position: absolute;
            bottom: 10px;
            left: 12px;
            right: 12px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .fingerprint-box {
            width: 50px;
            height: 38px;
            border: 2px solid #374151;
            border-radius: 4px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .fingerprint-label {
            font-size: 5.5px;
            color: #6b7280;
            text-align: center;
            font-weight: 600;
            padding: 2px;
        }

        .signature-box {
            text-align: center;
        }

        .signature-line {
            width: 90px;
            height: 18px;
            border-bottom: 1.5px solid #374151;
            margin-bottom: 2px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .signature-line img {
            max-width: 85px;
            max-height: 16px;
            object-fit: contain;
        }

        .official-name {
            font-size: 7.5px;
            font-weight: 700;
            color: #1f2937;
            text-transform: uppercase;
        }

        .official-title {
            font-size: 6px;
            color: #6b7280;
            font-style: italic;
            margin-top: 1px;
        }

        .loss-notice {
            position: absolute;
            bottom: 3px;
            left: 12px;
            right: 12px;
            text-align: center;
            font-size: 5px;
            color: #9ca3af;
            font-style: italic;
        }

        .thumbmark-area {
            position: absolute;
            right: 15px;
            bottom: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .fingerprint-box {
            width: 70px;
            height: 50px;
            border: 2px solid #374151;
            border-radius: 6px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .fingerprint-label {
            font-size: 6px;
            color: #6b7280;
            text-align: center;
            font-weight: 600;
        }
        .bottom-section {
    position: absolute;
    bottom: 10px;
    left: 12px;
    right: 12px;
    display: flex;
    justify-content: flex-end;
    align-items: flex-end;
}

.notes-signature-area {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-right: 10px; 
}

.signature-box {
    text-align: center;
}

.signature-line {
    width: 120px;
    height: 18px;
    border-bottom: 1.5px solid #374151;
    margin-bottom: 3px;
    display: flex;
    line-height: 1;
    align-items: flex-end;
    justify-content: center;
}

.signature-line img {
    max-width: 115px;
    max-height: 16px;
    line-height: 1;
    object-fit: contain;
    opacity: 0.95;
}

.official-name {
    font-size: 8px;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
    text-transform: uppercase;
    margin-top: 1px;
}

.official-title {
    font-size: 6px;
    line-height: 1;
    color: #6b7280;
    font-style: italic;
}

       
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            @page {
                size: 11in 8.5in landscape;
                margin: 0.5in;
            }

            body {
                background: white;
                padding: 0;
            }

            .id-container {
                gap: 0.75in;
                page-break-inside: avoid;
            }

            .id-card {
                page-break-inside: avoid;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }
        }
    </style>
</head>

<body>
    <div class="id-container"> 
        <div class="id-card id-card-front">
            <div class="header">
                <div class="header-logo">
                    @if ($barangayDetails && $barangayDetails->logo1_path && file_exists(storage_path('app/public/' . $barangayDetails->logo1_path)))
                        <img src="{{ Storage::url($barangayDetails->logo1_path) }}" class="front-header-logos" alt="Logo 1">
                    @else
                        <div style="width: 38px; height: 38px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6b7280; font-size: 10px;">LOGO</div>
                    @endif
                </div>
                <div class="header-text">
                    <h1>Republic of the Philippines</h1>
                    <h2>Province of Negros Occidental</h2>
                    <h2>Municipality of Hinoba-an</h2>
                    <h3>BARANGAY BACUYANGAN</h3>
                    <div class="header-subtitle">Office of the Punong Barangay</div>
                </div>
                <div class="header-logo">
                    @if ($barangayDetails && $barangayDetails->logo2_path && file_exists(storage_path('app/public/' . $barangayDetails->logo2_path)))
                        <img src="{{ Storage::url($barangayDetails->logo2_path) }}" class="front-header-logos" alt="Logo 2">
                    @else
                        <div style="width: 38px; height: 38px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6b7280; font-size: 10px;">LOGO</div>
                    @endif
                </div>
                <div class="ornament-line"></div>
            </div>
            <div class="card-type-badge">BARANGAY IDENTIFICATION CARD</div> <br>
            <hr>
            <div class="content-area">
                <div class="photo-container">
                    <div class="photo-frame">
                        @php
                            $photoPath = null;
                            
                            // Check profile_picture field
                            if(!empty($resident->profile_picture)) {
                                // Try multiple possible storage paths (handle double 'public' issue)
                                $possiblePaths = [
                                    'public/profile_pictures/' . $resident->profile_picture,  // Double public path
                                    'profile_pictures/' . $resident->profile_picture,          // Correct path
                                    $resident->profile_picture,                                // Direct filename
                                ];
                                
                                foreach($possiblePaths as $path) {
                                    // Check in storage/app/public
                                    $storagePath = storage_path('app/public/' . $path);
                                    if(file_exists($storagePath)) {
                                        $photoPath = asset('storage/' . $path);
                                        break;
                                    }
                                }
                                
                                // Fallback: construct URL anyway
                                if(!$photoPath) {
                                    if(strpos($resident->profile_picture, 'profile_pictures/') === 0) {
                                        $photoPath = asset('storage/' . $resident->profile_picture);
                                    } else {
                                        $photoPath = asset('storage/profile_pictures/' . $resident->profile_picture);
                                    }
                                }
                            }
                        @endphp
                        
                        @if($photoPath)
                            <img src="{{ $photoPath }}" 
                                 alt="Resident Photo" 
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 120\'%3E%3Crect fill=\'%23e5e7eb\' width=\'100\' height=\'120\'/%3E%3Ccircle cx=\'50\' cy=\'45\' r=\'20\' fill=\'%239ca3af\'/%3E%3Cpath d=\'M30 85 Q50 70 70 85 L70 120 L30 120 Z\' fill=\'%239ca3af\'/%3E%3C/svg%3E';">
                        @else
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 120'%3E%3Crect fill='%23e5e7eb' width='100' height='120'/%3E%3Ccircle cx='50' cy='45' r='20' fill='%239ca3af'/%3E%3Cpath d='M30 85 Q50 70 70 85 L70 120 L30 120 Z' fill='%239ca3af'/%3E%3C/svg%3E" 
                                 alt="No Photo Available" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                </div>
                <div class="id-number-badge">{{ strtoupper($resident->household_number ?? '') }}</div>
                <div class="info-section">
                    <div>
                        <div class="resident-name">
                            {{ $fullName ?? trim(($resident->first_name ?? '') . ' ' . ($resident->middle_name ? $resident->middle_name . ' ' : '') . ($resident->last_name ?? '')) }}
                        </div>
                        <div class="address-line">
                            {{ ($resident->purok->purok_name ?? $resident->address ?? 'Bacuyangan') . ', ' . ($barangayDetails->barangay ?? 'Bacuyangan') . ', ' . ($barangayDetails->city_municipality ?? 'Hinoba-an') . ', ' . ($barangayDetails->province ?? 'Negros Occidental') }}
                        </div>
                        <div class="info-grid">
                            <div class="info-row"> <span class="info-label">Sex:</span> <span
                                    class="info-value">{{ strtoupper($resident->sex ?? '') }}</span> </div>
                            <div class="info-row"> <span class="info-label">Civil Status:</span> <span
                                    class="info-value">{{ strtoupper($resident->civil_status ?? '') }}</span> </div>
                            <div class="info-row"> <span class="info-label">Date of Birth:</span> <span
                                    class="info-value">{{ $resident->birth_date ? strtoupper(date('M j, Y', strtotime($resident->birth_date))) : 'N/A' }}</span>
                            </div>
                            <div class="info-row"> <span class="info-label">Philsys Card #:</span> <span
                                    class="info-value">{{ strtoupper($resident->philsys_number ?? $resident->philhealth_number ?? 'N/A') }}</span> </div>
                        </div> 
                        <div class="thumbmark-area">
                            <div class="fingerprint-box">
                                <div class="fingerprint-label">Right Thumb Mark</div>
                            </div>
                        </div>
                    </div>
                    <div class="validity-container">
                        <div class="validity-box">
                            <div class="validity-row"> <span class="validity-label">Date Issued:</span> <span
                                    class="validity-date"> {{ strtoupper(date('m/d/Y')) }}</span> <span
                                    style="margin: 0 4px;">|</span> <span class="validity-label">Valid Until:</span>
                                <span
                                    class="validity-date">{{ strtoupper(date('m/d/Y', strtotime('+' . ($barangayDetails->validity_years ?? 3) . ' years'))) }}</span>
                            </div>
                        </div>
                        <div class="validity-box">
                            <div class="validity-row">
                                <div class="signature-area">
                                    <div class="signature-underline"></div> <span
                                        class="validity-label">Signature:</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="id-card id-card-back">
            <div class="back-header">
                <h2>{{ $barangayDetails->back_header ?? '⚠ This Card is Non-Transferable ⚠' }}</h2>
            </div>
            <div class="back-content">
                <div class="emergency-box">
                    <div class="emergency-title">🚨 In Case of Emergency Please Notify:</div>
                    <div class="emergency-info">
                        <div class="emergency-name">{{ strtoupper($barangayDetails->emergency_contact_name ?? 'BARANGAY OFFICE') }}</div>
                        <div>{{ $barangayDetails->emergency_contact_number ?? '(034) XXX-XXXX' }}</div>
                        <div>{{ $barangayDetails->emergency_contact_address ?? 'Bacuyangan, Hinoba-an, Negros Occidental' }}</div>
                    </div>
                </div>
                <div class="certification">
                    {{ $barangayDetails->back_certification ?? 'This certifies that the person whose name and picture appear on the reverse side of this card is a bonafide resident of BARANGAY BACUYANGAN, Municipality of Hinoba-an, Province of Negros Occidental, Philippines.' }}
                </div>
                <div class="notes-box">
                    <div class="notes-title">⚠ IMPORTANT NOTES:</div>
                    <div class="notes-text">
                        {{ $barangayDetails->back_note ?? '• This ID is the property of the Barangay • Present this ID when transacting with the barangay • Report immediately if lost or stolen' }}
                    </div>
                </div>
                <div class="bottom-section">
                    <div class="notes-signature-area">
                        <div class="signature-box">
                            <div class="signature-line">
                                @if ($barangayDetails && $barangayDetails->signature_path && file_exists(storage_path('app/public/' . $barangayDetails->signature_path)))
                                    <img src="{{ Storage::url($barangayDetails->signature_path) }}" alt="Signature">
                                @endif
                            </div>
                            <div class="official-name">{{ strtoupper($barangayDetails->captain_name ?? 'HON. NOEL R. LAYDA') }}</div>
                            <div class="official-title">Punong Barangay</div>
                        </div>
                    </div>
                </div>
                
                
            </div>
            <div class="loss-notice">
                {{ $barangayDetails->back_loss_info ?? 'If found, please return to Barangay Bacuyangan Office' }}
            </div>
        </div>
    </div>

    <script>
        let printCompleted = false;
        
        // Auto-print when page loads
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 500);
        });

        function handleRedirect() {
            if (!printCompleted) {
                printCompleted = true;
                
                // Check if this page was opened in a popup/new window
                if (window.opener && !window.opener.closed) {
                    // If opened from another window, just close this window
                    window.close();
                } else if (window.history.length > 1) {
                    // If there's history, go back instead of redirecting
                    window.history.back();
                } else {
                    // Normal redirect for direct access
                    document.body.style.display = 'none';
                    window.location.replace('{{ route("resident.index") }}');
                }
            }
        }

        // Handle print completion/cancellation
        window.addEventListener('afterprint', function() {
            setTimeout(handleRedirect, 100);
        });

        // Fallback: detect when print dialog is closed (browser regains focus)
        let mediaQuery = window.matchMedia('print');
        mediaQuery.addListener(function(mq) {
            if (!mq.matches) {
                setTimeout(handleRedirect, 100);
            }
        });

        // Ultimate fallback: redirect after reasonable time
        setTimeout(function() {
            handleRedirect();
        }, 5000);

        // Handle window focus (when print dialog closes)
        window.addEventListener('focus', function() {
            setTimeout(handleRedirect, 200);
        }, { once: true });
    </script>
</body>

</html>
