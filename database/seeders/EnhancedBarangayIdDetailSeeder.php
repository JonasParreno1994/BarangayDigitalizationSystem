<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BarangayIdDetail;

class EnhancedBarangayIdDetailSeeder extends Seeder
{
    public function run()
    {
        // Check if any barangay ID details already exist
        if (BarangayIdDetail::count() > 0) {
            // Update existing record with enhanced data
            $existingDetail = BarangayIdDetail::first();
            $enhancedData = BarangayIdDetail::getDefaultEnhancedData();
            $existingDetail->update($enhancedData);
        } else {
            // Create new record with enhanced data
            $enhancedData = BarangayIdDetail::getDefaultEnhancedData();
            
            // Add basic required fields
            $enhancedData = array_merge($enhancedData, [
                'heading1' => 'REPUBLIC OF THE PHILIPPINES',
                'heading2' => 'PROVINCE OF NEGROS OCCIDENTAL',
                'heading3' => 'MUNICIPALITY OF HINOBA-AN',
                'validity' => '3 years',
                'details' => 'This ID card serves as official identification for residents of Barangay Bacuyangan.',
                'pass_captain' => 'NOEL R. LAYDA',
                'logo1_path' => null, 
                'logo2_path' => null,
                'signature_path' => null, 
            ]);
            
            BarangayIdDetail::create($enhancedData);
        }
    }
}
