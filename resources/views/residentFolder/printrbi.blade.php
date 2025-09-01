<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBI FORM B - Individual Record of Barangay Inhabitant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 15px;
            line-height: 1.2;
            background: white;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 15px;
        }
        .form-header {
            text-align: left;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .form-title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }
        .region-section {
            margin-bottom: 15px;
        }
        .region-row {
            display: flex;
            gap: 50px;
            margin-bottom: 8px;
            align-items: center;
        }
        .region-field {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .region-label {
            font-weight: bold;
            min-width: 80px;
        }
        .region-input {
            border: 1px solid #000;
            height: 25px;
            padding: 2px 5px;
            min-width: 200px;
        }
        .personal-info-box {
            border: 2px solid #000;
            padding: 15px;
            margin: 15px 0;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 12px;
        }
        .name-section {
            margin-bottom: 15px;
        }
        .name-label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }
        .name-inputs {
            display: flex;
            gap: 10px;
            margin-bottom: 5px;
        }
        .name-input {
            border: 1px solid #000;
            height: 30px;
            padding: 2px 5px;
            flex: 1;
        }
        .name-labels {
            display: flex;
            gap: 10px;
            font-size: 10px;
            text-align: center;
        }
        .name-label-item {
            flex: 1;
            text-align: center;
            font-weight: bold;
            margin-top: 3px;
        }
        .birth-section {
            margin-bottom: 15px;
        }
        .birth-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }
        .birth-label {
            font-weight: bold;
            min-width: 100px;
        }
        .birth-input {
            border: 1px solid #000;
            height: 25px;
            padding: 2px 5px;
            width: 40px;
            text-align: center;
        }
        .birth-input.year {
            width: 60px;
        }
        .birth-labels {
            display: flex;
            gap: 10px;
            margin-left: 110px;
            font-size: 10px;
            font-weight: bold;
        }
        .place-birth {
            margin-bottom: 15px;
        }
        .place-input {
            border: 1px solid #000;
            height: 25px;
            padding: 2px 5px;
            width: 100%;
            margin-top: 5px;
        }
        .checkbox-section {
            margin-bottom: 15px;
        }
        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 10px;
        }
        .checkbox-label {
            font-weight: bold;
            min-width: 80px;
        }
        .checkbox-group {
            display: flex;
            gap: 15px;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .checkbox {
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .single-field {
            margin-bottom: 15px;
        }
        .single-field-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .single-label {
            font-weight: bold;
            min-width: 150px;
        }
        .single-input {
            border: 1px solid #000;
            height: 25px;
            padding: 2px 5px;
            flex: 1;
        }
        .address-section {
            margin-bottom: 15px;
        }
        .address-row {
            display: flex;
            gap: 10px;
            margin-bottom: 8px;
        }
        .address-field {
            flex: 1;
        }
        .address-input {
            border: 1px solid #000;
            height: 25px;
            padding: 2px 5px;
            width: 100%;
            margin-top: 3px;
        }
        .address-label {
            font-weight: bold;
            font-size: 10px;
            text-align: center;
            display: block;
        }
        .certification-section {
            margin: 30px 0;
            text-align: center;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin: 30px 0;
            align-items: end;
        }
        .signature-left {
            text-align: center;
            border-bottom: 1px solid #000;
            width: 200px;
            padding-bottom: 2px;
            margin-bottom: 5px;
        }
        .signature-right {
            text-align: center;
            border-bottom: 1px solid #000;
            width: 250px;
            padding-bottom: 2px;
            margin-bottom: 5px;
        }
        .thumbmark-section {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin: 20px 0;
        }
        .thumbmark {
            text-align: center;
        }
        .thumbmark-box {
            border: 1px solid #000;
            width: 80px;
            height: 60px;
            margin: 5px auto;
        }
        .attestation-section {
            margin: 30px 0;
        }
        .household-number {
            text-align: center;
            margin: 20px 0;
        }
        .household-input {
            border: 1px solid #000;
            height: 25px;
            padding: 2px 5px;
            width: 150px;
            margin-top: 5px;
        }
        .barangay-secretary {
            text-align: center;
            border-bottom: 1px solid #000;
            width: 200px;
            margin: 30px auto 10px;
            padding-bottom: 2px;
        }
        .note-section {
            font-size: 10px;
            margin-top: 20px;
            font-weight: bold;
        }
        @media print {
            body { margin: 0; font-size: 10px; }
            .no-print { display: none; }
            .form-container { border: 2px solid #000; }
        }
    </style>
</head>
<body>
    <div class="form-container">
       
        <div class="form-header">
            <strong>RBI FORM B</strong>
        </div>
        
        <div class="form-title">INDIVIDUAL RECORD OF BARANGAY INHABITANT</div>

        
        <div class="region-section">
            <div class="region-row">
                <div class="region-field">
                    <span class="region-label">REGION:</span>
                    <div class="region-input">{{ $resident->region }}</div>
                </div>
                <div class="region-field">
                    <span class="region-label">CITY/MUN:</span>
                    <div class="region-input">{{ $resident->city_municipality }}</div>
                </div>
            </div>
            <div class="region-row">
                <div class="region-field">
                    <span class="region-label">PROVINCE:</span>
                    <div class="region-input">{{ $resident->province }}</div>
                </div>
                <div class="region-field">
                    <span class="region-label">BARANGAY:</span>
                    <div class="region-input">{{ $resident->barangay }}</div>
                </div>
            </div>
        </div>

       
        <div class="personal-info-box">
            <div class="section-title">I. PERSONAL INFORMATION</div>

           
            <div class="name-section">
                <span class="name-label">NAME:</span>
                <div class="name-inputs">
                    <input type="text" class="name-input" value="{{ $resident->last_name }}" readonly>
                    <input type="text" class="name-input" value="{{ $resident->first_name }}" readonly>
                    <input type="text" class="name-input" value="{{ $resident->middle_name ?? '' }}" readonly>
                    <input type="text" class="name-input" value="{{ $resident->suffix ?? '' }}" readonly style="max-width: 80px;">
                </div>
                <div class="name-labels">
                    <div class="name-label-item">Last Name</div>
                    <div class="name-label-item">First Name</div>
                    <div class="name-label-item">Middle Name</div>
                    <div class="name-label-item">EXT.</div>
                </div>
            </div>

            
            <div class="birth-section">
                <div class="birth-row">
                    <span class="birth-label">DATE OF BIRTH:</span>
                    <input type="text" class="birth-input" value="{{ date('m', strtotime($resident->birth_date)) }}" readonly>
                    <input type="text" class="birth-input" value="{{ date('d', strtotime($resident->birth_date)) }}" readonly>
                    <input type="text" class="birth-input year" value="{{ date('Y', strtotime($resident->birth_date)) }}" readonly>
                </div>
                <div class="birth-labels">
                    <span style="width: 40px; text-align: center;">MM</span>
                    <span style="width: 40px; text-align: center;">DD</span>
                    <span style="width: 60px; text-align: center;">YYYY</span>
                </div>
            </div>

          
            <div class="place-birth">
                <div class="single-field-row">
                    <span class="single-label" style="min-width: 100px;">PLACE OF BIRTH:</span>
                </div>
                <input type="text" class="place-input" value="{{ $resident->birth_place }}" readonly>
            </div>

            
            <div class="checkbox-section">
                <div class="checkbox-row">
                    <span class="checkbox-label">SEX:</span>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <div class="checkbox">{{ $resident->sex === 'Male' ? '✓' : '' }}</div>
                            <span>MALE</span>
                        </div>
                        <div class="checkbox-item">
                            <div class="checkbox">{{ $resident->sex === 'Female' ? '✓' : '' }}</div>
                            <span>FEMALE</span>
                        </div>
                    </div>
                    <span class="checkbox-label">CIVIL STATUS:</span>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <div class="checkbox">{{ $resident->civil_status === 'Single' ? '✓' : '' }}</div>
                            <span>SINGLE</span>
                        </div>
                        <div class="checkbox-item">
                            <div class="checkbox">{{ $resident->civil_status === 'Married' ? '✓' : '' }}</div>
                            <span>MARRIED</span>
                        </div>
                        <div class="checkbox-item">
                            <div class="checkbox">{{ $resident->civil_status === 'Widowed' ? '✓' : '' }}</div>
                            <span>WIDOW / ER</span>
                        </div>
                        <div class="checkbox-item">
                            <div class="checkbox">{{ $resident->civil_status === 'Separated' ? '✓' : '' }}</div>
                            <span>SEPARATED</span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="single-field">
                <div class="single-field-row">
                    <span class="single-label">CITIZENSHIP:</span>
                    <input type="text" class="single-input" value="{{ $resident->citizenship }}" readonly>
                </div>
            </div>

            
            <div class="single-field">
                <div class="single-field-row">
                    <span class="single-label">PROFESSION/OCCUPATION:</span>
                    <input type="text" class="single-input" value="{{ $resident->occupation ?? '' }}" readonly>
                </div>
            </div>

            
            <div class="address-section">
                <div style="font-weight: bold; margin-bottom: 10px;">RESIDENCE ADDRESS</div>
                <div class="address-row">
                    <div class="address-field">
                        <input type="text" class="address-input" value="{{ $resident->household_number ?? '' }}" readonly>
                        <span class="address-label">House No.</span>
                    </div>
                    <div class="address-field" style="flex: 2;">
                        <input type="text" class="address-input" value="{{ $address }}" readonly>
                        <span class="address-label">Street Name</span>
                    </div>
                </div>
                <div style="margin-top: 10px;">
                    <input type="text" class="address-input" value="{{ $resident->purok ? $resident->purok->purok_name : '' }}, {{ $resident->barangay }}, {{ $resident->city_municipality }}" readonly>
                    <span class="address-label">Subdivision Name/Zone/Sitio/Purok</span>
                </div>
            </div>
        </div>

        
        <div class="certification-section">
            <strong>I Hereby certify that the above information is true and correct to the best of my knowledge</strong>
        </div>

       
        <div class="signature-section">
            <div>
                <div class="signature-left">&nbsp;</div>
                <div style="text-align: center; font-weight: bold; font-size: 10px;">Date Accomplished</div>
            </div>
            <div>
                <div class="signature-right">&nbsp;</div>
                <div style="text-align: center; font-weight: bold; font-size: 10px;">Name /Signature of Person Accomplishing the Form</div>
            </div>
        </div>

        
        <div class="thumbmark-section">
            <div class="thumbmark">
                <div class="thumbmark-box"></div>
                <div style="font-weight: bold; font-size: 10px;">Left Thumbmark</div>
            </div>
            <div class="thumbmark">
                <div class="thumbmark-box"></div>
                <div style="font-weight: bold; font-size: 10px;">Right Thumbmark</div>
            </div>
        </div>

        
        <div class="attestation-section">
            <div style="display: flex; align-items: center; gap: 20px;">
                <span style="font-weight: bold;">Attested by:</span>
                <div class="household-number">
                    <input type="text" class="household-input" value="{{ $resident->household_number ?? '' }}" readonly>
                    <div style="font-weight: bold; font-size: 10px; margin-top: 3px;">Household Number</div>
                </div>
            </div>
        </div>

        
        <div style="text-align: center; margin: 30px 0;">
            <div class="barangay-secretary">&nbsp;</div>
            <div style="font-weight: bold; font-size: 10px;">Barangay Secretary</div>
        </div>

        
        <div class="note-section">
            <strong>Note: the household No. shall be filled up by the Barangay Secretary</strong>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
                window.close();
            }, 1000);
        }
    </script>
</body>
</html>
