<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BarangayDetail;

class BarangayDetailSeeder extends Seeder
{
    public function run()
    {
        BarangayDetail::create([
            'region' => 'VI',
            'province' => 'NEGROS OCCIDENTAL',
            'city_municipality' => 'HINOBA-AN',
            'barangay_name' => 'BACUYANGAN',
            'district' => '1st District',
            'zip_code' => '6114',
            'complete_address' => 'Barangay Bacuyangan, Hinoba-an, Negros Occidental',
            
            'captain_name' => 'JOHNNY RAY L. RELIQUIAS',
            'captain_title' => 'Barangay Captain',
            'secretary_name' => 'ROWENA A. MINAVES',
            'secretary_title' => 'Barangay Secretary',
            'treasurer_name' => 'MARIA SANTOS',
            'treasurer_title' => 'Barangay Treasurer',
            
            'barangay_contact' => '(034) 123-4567',
            'barangay_email' => 'barangay.bacuyangan@hinoba-an.gov.ph',
            'emergency_contact' => '911',
            'office_hours' => '8:00 AM - 5:00 PM, Monday to Friday',
            
            'heading1' => 'REPUBLIC OF THE PHILIPPINES',
            'heading2' => 'PROVINCE OF NEGROS OCCIDENTAL',
            'heading3' => 'MUNICIPALITY OF HINOBA-AN',
            'document_footer' => 'This is to certify that the above information is true and correct.',
            
            'certificate_validity_period' => '1 year',
            'or_number_prefix' => 'OR-',
            'document_series_prefix' => '2024-',
            
            'clearance_fee' => 50.00,
            'residency_fee' => 30.00,
            'indigency_fee' => 20.00,
            'good_moral_fee' => 30.00,
            'death_cert_fee' => 50.00,
            'jobseeker_fee' => 0.00,
            'id_replacement_fee' => 100.00,
            
            'barangay_established_date' => '1950-01-01',
            'total_area' => '12.5 sq km',
            'total_population' => 5000,
            'total_households' => 1200,
            'barangay_classification' => 'Rural',
            'income_classification' => '3rd Class',
            
            'is_active' => true
        ]);
    }
}
