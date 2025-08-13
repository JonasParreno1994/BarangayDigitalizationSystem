<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Records of Barangay Inhabitant</title>
    <style>
        @page { size: A4; margin: 0.5cm; }
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0.5cm; font-size: 12px; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #007bff; }
        .header h1 { font-size: 16px; margin: 0; text-decoration: underline; }
        .profile-img { width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 1px solid #007bff; margin-bottom: 5px; }
        .section { margin-bottom: 12px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .section h2 { font-size: 13px; margin-bottom: 8px; color: #007bff; text-decoration: underline; }
        .form-field { margin-bottom: 8px; padding: 4px 8px; min-height: 18px; border-bottom: 1px solid #eee; }
        .form-label { font-weight: 600; display: block; color: #495057; margin-bottom: 1px; font-size: 11px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 11px; }
        .info-table td { padding: 6px 8px; border: 1px solid #ddd; }
        .grid { display: flex; flex-wrap: wrap; gap: 8px; }
        .col { flex: 1 1 120px; min-width: 100px; }
        .col-2 { flex: 2 1 240px; }
        .highlight { background: #e9f7ef; color: #218838; }
        .warn { background: #fff3cd; color: #856404; }
        .danger { background: #f8d7da; color: #721c24; }
        .footer { margin-top: 15px; font-size: 10px; color: #555; text-align: right; }
        .signature-area { display: flex; justify-content: space-between; margin-top: 20px; gap: 20px; }
        .signature-box { width: 150px; border-top: 1px solid #007bff; text-align: center; padding-top: 5px; font-size: 11px; margin-top: 15px; }
        .thumbmark-area { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
        .thumbmark-label { font-size: 10px; color: #555; }
        .thumbmark { display: inline-block; width: 50px; height: 25px; border: 1px solid #007bff; border-radius: 4px; }
        .education-option { display: inline-block; margin-right: 10px; }
        @media print {
            body { margin: 0; padding: 0; }
            .section { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INDIVIDUAL RECORDS OF BARANGAY INHABITANT</h1>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>REGION:</strong> {{ $resident->region }}</td>
            <td><strong>CITY/MUN:</strong> {{ $resident->city_municipality }}</td>
        </tr>
        <tr>
            <td><strong>PROVINCE:</strong> {{ $resident->province }}</td>
            <td><strong>BARANGAY:</strong> {{ $resident->barangay }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>PUROK:</strong>
                {{ \App\Models\Purok::find($resident->purok_id)->purok_name ?? 'No purok selected' }}
            </td>
        </tr>
    </table>

    <div class="section">
        <h2>PERSONAL INFORMATION</h2>
        <div class="grid" style="align-items: flex-start;">
            <div class="col" style="max-width:80px;">
                @if($resident->profile_picture)
                    <img src="{{ asset('storage/public/profile_pictures/' . basename($resident->profile_picture)) }}" alt="Profile Image" class="profile-img">
                @else
                    <div class="profile-img" style="background:#e9ecef;display:flex;align-items:center;justify-content:center;">
                        <span style="font-size:30px;color:#bbb;">&#128100;</span>
                    </div>
                @endif
            </div>
            <div class="col-2">
                <div class="grid">
                    <div class="col">
                        <div class="form-label">Last Name</div>
                        <div class="form-field">{{ $resident->last_name }}</div>
                    </div>
                    <div class="col">
                        <div class="form-label">First Name</div>
                        <div class="form-field">{{ $resident->first_name }}</div>
                    </div>
                    <div class="col">
                        <div class="form-label">Middle Name</div>
                        <div class="form-field">{{ $resident->middle_name ?? '____' }}</div>
                    </div>
                    <div class="col">
                        <div class="form-label">Suffix</div>
                        <div class="form-field">{{ $resident->suffix ?? 'None' }}</div>
                    </div>
                </div>
                <div class="grid">
                    <div class="col">
                        <div class="form-label">Birth Date</div>
                        <div class="form-field">{{ \Carbon\Carbon::parse($resident->birth_date)->format('F d, Y') }}</div>
                    </div>
                    <div class="col">
                        <div class="form-label">Age</div>
                        <div class="form-field">{{ \Carbon\Carbon::parse($resident->birth_date)->age }} years old</div>
                    </div>
                    <div class="col">
                        <div class="form-label">Sex</div>
                        <div class="form-field">{{ $resident->sex }}</div>
                    </div>
                </div>
                <div class="grid">
                    <div class="col">
                        <div class="form-label">Civil Status</div>
                        <div class="form-field">{{ $resident->civil_status }}</div>
                    </div>
                    <div class="col">
                        <div class="form-label">Citizenship</div>
                        <div class="form-field">{{ $resident->citizenship }}</div>
                    </div>
                    <div class="col">
                        <div class="form-label">Religion</div>
                        <div class="form-field">{{ $resident->religion ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="form-label">Residence Address</div>
                <div class="form-field">{{ $resident->address }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>SPECIAL POPULATION INFORMATION</h2>
        <div class="grid">
            <div class="col">
                <div class="form-label">Senior Citizen</div>
                @if($resident->is_senior_citizen)
                    <div class="form-field highlight">Registered Senior Citizen</div>
                    <div class="form-label">Senior Citizen ID</div>
                    <div class="form-field">{{ $resident->senior_citizen_id ?? 'Not specified' }}</div>
                @else
                    <div class="form-field warn">Not a Senior Citizen</div>
                @endif
            </div>
            <div class="col">
                <div class="form-label">Person With Disability (PWD)</div>
                @if($resident->is_pwd)
                    <div class="form-field highlight">Registered PWD</div>
                    <div class="form-label">PWD ID Number</div>
                    <div class="form-field">{{ $resident->pwd_id ?? 'Not specified' }}</div>
                @else
                    <div class="form-field warn">Not a PWD</div>
                @endif
            </div>
            <div class="col">
                <div class="form-label">Solo Parent</div>
                @if($resident->is_solo_parent)
                    <div class="form-field highlight">Registered Solo Parent</div>
                    <div class="form-label">Solo Parent ID</div>
                    <div class="form-field">{{ $resident->solo_parent_id ?? 'Not specified' }}</div>
                @else
                    <div class="form-field warn">Not a Solo Parent</div>
                @endif
            </div>
        </div>
    </div>

    <div class="section">
        <h2>CONTACT & OTHER INFORMATION</h2>
        <div class="grid">
            <div class="col">
                <div class="form-label">Contact Number</div>
                <div class="form-field">{{ $resident->contact_number ?? 'N/A' }}</div>
            </div>
            <div class="col">
                <div class="form-label">Email Address</div>
                <div class="form-field">{{ $resident->email ?? 'N/A' }}</div>
            </div>
            <div class="col">
                <div class="form-label">Profession/Occupation</div>
                <div class="form-field">{{ $resident->occupation ?? 'N/A' }}</div>
            </div>
            <div class="col">
                <div class="form-label">Voter Status</div>
                <div class="form-field">{{ $resident->voter_status }}</div>
            </div>
        </div>
        <div class="grid">
            @if($resident->voter_status === 'Voter')
            <div class="col">
                <div class="form-label">Precinct Number</div>
                <div class="form-field">{{ $resident->precinct_number ?? 'N/A' }}</div>
            </div>
            @endif
            <div class="col">
                <div class="form-label">Household Number</div>
                <div class="form-field">{{ $resident->household_number ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <div class="section" style="margin-bottom: 5px;">
        <h2>HIGHEST EDUCATIONAL ATTAINMENT</h2>
        <div class="grid">
            <div class="col">
                <div class="form-label">Education</div>
                <div class="form-field">{{ $resident->education ?? 'N/A' }}</div>
            </div>
            <div class="col">
                <div class="form-label">Education Status</div>
                <div class="form-field">{{ $resident->education_status ?? 'N/A' }}</div>
            </div>
        </div>
        <div style="margin-top:8px;">
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
        <div style="margin-top: 8px;">
            <div style="display: inline-block; margin-right: 15px;">
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
            <div style="font-weight: 500; margin-bottom: 5px; font-size:11px;">Attested By:</div>
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
        <div>
            <strong>Household Number:</strong> {{ $resident->household_number }},
            Date Printed: {{ now()->format('m/d/Y h:i A') }}
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