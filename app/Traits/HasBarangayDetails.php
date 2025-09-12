<?php

namespace App\Traits;

use App\Models\BarangayDetail;
use App\Models\BarangayIdDetail;

trait HasBarangayDetails
{
    /**
     * Get barangay details for forms and documents
     * Falls back to BarangayIdDetail if BarangayDetail is not available
     */
    protected function getBarangayDetails()
    {
        // Try to get from new comprehensive model first
        $barangayDetails = BarangayDetail::getActiveDetails();
        
        // If not found, fallback to existing BarangayIdDetail model
        if (!$barangayDetails) {
            $barangayDetails = BarangayIdDetail::first();
        }
        
        return $barangayDetails;
    }

    /**
     * Get barangay details with specific format for print documents
     */
    protected function getBarangayDetailsForPrint()
    {
        $details = $this->getBarangayDetails();
        
        if (!$details) {
            return $this->getDefaultBarangayDetails();
        }
        
        return $details;
    }

    /**
     * Get default barangay details if none are set
     */
    private function getDefaultBarangayDetails()
    {
        return (object) [
            'region' => 'VI',
            'province' => 'NEGROS OCCIDENTAL',
            'city_municipality' => 'HINOBA-AN',
            'barangay_name' => 'BACUYANGAN',
            'captain_name' => 'BARANGAY CAPTAIN',
            'secretary_name' => 'BARANGAY SECRETARY',
            'heading1' => 'REPUBLIC OF THE PHILIPPINES',
            'heading2' => 'PROVINCE OF NEGROS OCCIDENTAL',
            'heading3' => 'MUNICIPALITY OF HINOBA-AN',
            'logo1_path' => null,
            'logo2_path' => null,
            'barangay_contact' => '(034) 123-4567',
            'emergency_contact' => '911',
            'clearance_fee' => 50.00,
            'residency_fee' => 30.00,
            'indigency_fee' => 20.00,
            'good_moral_fee' => 30.00,
            'death_cert_fee' => 50.00,
            'jobseeker_fee' => 0.00,
        ];
    }

    /**
     * Add barangay details to view data
     */
    protected function withBarangayDetails($viewData = [])
    {
        $viewData['barangayDetails'] = $this->getBarangayDetailsForPrint();
        return $viewData;
    }
}
