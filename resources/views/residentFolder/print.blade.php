<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Records of Barangay Inhabitant</title>
    <style>
        @page {
            size: A4;
            margin: 0.8cm;
            scale: 0.77;
        }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 1.5cm;
            background: #f8f9fa;
            color: #222;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
            position: relative;
        }
        .header .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 60px;
            height: 60px;
            background: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #007bff;
        }
        .header h1 {
            font-size: 22px;
            margin: 0;
            text-decoration: underline;
            letter-spacing: 1px;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 25px;
            background: #fff;
            box-shadow: 0 1px 4px #0001;
            border-radius: 8px;
            overflow: hidden;
        }
        table td {
            border: none;
            padding: 10px 16px;
            font-size: 15px;
        }
        table tr:not(:last-child) td {
            border-bottom: 1px solid #dee2e6;
        }
        .section {
            margin-bottom: 28px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 4px #0001;
            padding: 18px 20px 10px 20px;
        }
        .section h2 {
            font-size: 17px;
            margin-bottom: 14px;
            color: #007bff;
            text-decoration: underline;
        }
        .form-field {
            margin-bottom: 13px;
            background: #f1f3f6;
            border-radius: 5px;
            padding: 7px 12px;
            min-height: 22px;
            border-bottom: 1px solid #dee2e6;
        }
        .form-label {
            font-weight: 600;
            display: block;
            color: #495057;
            margin-bottom: 2px;
            font-size: 14px;
        }
        .education-options {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-bottom: 10px;
        }
        .education-option {
            display: flex;
            align-items: center;
            font-size: 15px;
            gap: 6px;
        }
        .education-option input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #007bff;
        }
        .signature-area {
            display: flex;
            justify-content: space-between;
            margin-top: 45px;
            gap: 40px;
        }
        .signature-box {
            width: 220px;
            border-top: 2px solid #007bff;
            text-align: center;
            padding-top: 7px;
            font-size: 14px;
            font-weight: 500;
            margin-top: 30px;
        }
        .thumbmark-area {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 12px;
        }
        .thumbmark-label {
            font-size: 13px;
            color: #555;
        }
        .thumbmark {
            display: inline-block;
            width: 70px;
            height: 38px;
            border: 1.5px solid #007bff;
            border-radius: 6px;
            background: #f8f9fa;
            margin: 0 4px;
        }
        .footer {
            margin-top: 35px;
            font-size: 13px;
            color: #555;
            text-align: right;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 0;
                background: #fff;
            }
            .section, table {
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INDIVIDUAL RECORDS OF BARANGAY INHABITANT</h1>
    </div>

    <table>
        <tr>
            <td><strong>REGION:</strong> {{ $resident->region }}</td>
            <td><strong>CITY/MUN:</strong> {{ $resident->city_municipality }}</td>
        </tr>
        <tr>
            <td><strong>PROVINCE:</strong> {{ $resident->province }}</td>
            <td><strong>BARANGAY:</strong> {{ $resident->barangay }}</td>
        </tr>
    </table>

    <div class="section">
        <h2>PERSONAL INFORMATION</h2>
        <div class="form-field">
            <span class="form-label">Philsys Card No.</span>
            {{ $resident->census_no ?? '____________________' }}
        </div>
        <div style="display: flex; gap: 20px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <div class="form-label">Last Name</div>
                <div class="form-field">{{ $resident->last_name }}</div>
            </div>
            <div style="width: 80px;">
                <div class="form-label">Suffix</div>
                <div class="form-field">{{ $resident->suffix ?? '____' }}</div>
            </div>
        </div>
        <div style="display: flex; gap: 20px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <div class="form-label">First Name</div>
                <div class="form-field">{{ $resident->first_name }}</div>
            </div>
            <div style="flex: 1;">
                <div class="form-label">Middle Name</div>
                <div class="form-field">{{ $resident->middle_name ?? '____' }}</div>
            </div>
        </div>
        <div style="display: flex; gap: 20px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <div class="form-label">Birth Date</div>
                <div class="form-field">{{ \Carbon\Carbon::parse($resident->birth_date)->format('m/d/Y') }}</div>
            </div>
            <div style="flex: 1;">
                <div class="form-label">Birth Place</div>
                <div class="form-field">{{ $resident->birth_place }}</div>
            </div>
        </div>
        <div style="display: flex; gap: 20px; margin-bottom: 15px;">
            <div style="width: 100px;">
                <div class="form-label">Sex</div>
                <div class="form-field">{{ $resident->sex }}</div>
            </div>
            <div style="flex: 1;">
                <div class="form-label">Civil Status</div>
                <div class="form-field">{{ $resident->civil_status }}</div>
            </div>
            <div style="flex: 1;">
                <div class="form-label">Religion</div>
                <div class="form-field">{{ $resident->religion ?? '____' }}</div>
            </div>
        </div>
        <div class="form-field" style="margin-bottom: 15px;">
            <div class="form-label">Residence Address</div>
            {{ $resident->address }}
        </div>
        <div class="form-field">
            <div class="form-label">Citizenship</div>
            {{ $resident->citizenship }}
        </div>
        <div style="display: flex; gap: 20px; margin-top: 15px;">
            <div style="flex: 1;">
                <div class="form-label">Profession/Occupation</div>
                <div class="form-field">{{ $resident->occupation ?? '____' }}</div>
            </div>
            <div style="flex: 1;">
                <div class="form-label">Contact Number</div>
                <div class="form-field">{{ $resident->contact_number ?? '____' }}</div>
            </div>
            <div style="flex: 1;">
                <div class="form-label">E-mail Address</div>
                <div class="form-field">{{ $resident->email ?? '____' }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>HIGHEST EDUCATIONAL ATTAINMENT</h2>
        <div class="education-options">
            <div class="education-option">
                <input type="checkbox" {{ str_contains(strtolower($resident->education ?? ''), 'elementary') ? 'checked' : '' }}> ELEMENTARY
            </div>
            <div class="education-option">
                <input type="checkbox" {{ str_contains(strtolower($resident->education ?? ''), 'high school') ? 'checked' : '' }}> HIGH SCHOOL
            </div>
            <div class="education-option">
                <input type="checkbox" {{ str_contains(strtolower($resident->education ?? ''), 'college') ? 'checked' : '' }}> COLLEGE
            </div>
            <div class="education-option">
                <input type="checkbox" {{ str_contains(strtolower($resident->education ?? ''), 'post grad') ? 'checked' : '' }}> POST GRAD
            </div>
            <div class="education-option">
                <input type="checkbox" {{ str_contains(strtolower($resident->education ?? ''), 'vocational') ? 'checked' : '' }}> VOCATIONAL
            </div>
        </div>
        <div style="margin-top: 15px;">
            <div style="display: inline-block; margin-right: 30px;">
                <input type="checkbox" {{ $resident->education_status === 'Graduate' ? 'checked' : '' }}> Graduate
            </div>
            <div style="display: inline-block;">
                <input type="checkbox" {{ $resident->education_status === 'Under Graduate' ? 'checked' : '' }}> Under Graduate
            </div>
        </div>
    </div>

    <div class="signature-area">
        <div>
            <div class="signature-box">Name/Signature of Person Accomplishing the Form</div>
        </div>
        <div>
            <div style="font-weight: 500; margin-bottom: 8px;">Attested By:</div>
            <div class="signature-box">Barangay Secretary</div>
            <div class="thumbmark-area">
                <span class="thumbmark-label">Left Thumbmark</span>
                <div class="thumbmark"></div>
                <span class="thumbmark-label">Right Thumbmark</span>
                <div class="thumbmark"></div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div><strong>Household Number:</strong> {{ $resident->household_number }},  Date Printed: {{ now()->format('m/d/Y h:i A') }}</div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>