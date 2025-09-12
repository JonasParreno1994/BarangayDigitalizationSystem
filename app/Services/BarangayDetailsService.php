<?php

namespace App\Services;

use App\Models\BarangayDetail;
use App\Models\BarangayIdDetail;

class BarangayDetailsService
{
    /**
     * Get barangay details for forms and documents
     * Falls back to BarangayIdDetail if BarangayDetail is not available
     */
    public static function getDetails()
    {
        // Try to get from new comprehensive model first
        $barangayDetails = BarangayDetail::getActiveDetails();
        
        // If not found, fallback to existing BarangayIdDetail model
        if (!$barangayDetails) {
            $barangayDetails = BarangayIdDetail::first();
        }
        
        // If still not found, return default values
        if (!$barangayDetails) {
            return self::getDefaultDetails();
        }
        
        return $barangayDetails;
    }

    /**
     * Get default barangay details if none are set
     */
    private static function getDefaultDetails()
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
            'id_replacement_fee' => 100.00,
        ];
    }

    /**
     * Get formatted header for documents
     */
    public static function getFormattedHeader($barangayDetails = null)
    {
        if (!$barangayDetails) {
            $barangayDetails = self::getDetails();
        }

        return [
            'line1' => $barangayDetails->heading1 ?? 'REPUBLIC OF THE PHILIPPINES',
            'line2' => $barangayDetails->heading2 ?? "{$barangayDetails->province}, {$barangayDetails->city_municipality}",
            'line3' => $barangayDetails->heading3 ?? "BARANGAY {$barangayDetails->barangay_name}"
        ];
    }

    /**
     * Get fee for specific document type
     */
    public static function getFee($documentType, $barangayDetails = null)
    {
        if (!$barangayDetails) {
            $barangayDetails = self::getDetails();
        }

        $fees = [
            'clearance' => $barangayDetails->clearance_fee ?? 50.00,
            'residency' => $barangayDetails->residency_fee ?? 30.00,
            'indigency' => $barangayDetails->indigency_fee ?? 20.00,
            'good_moral' => $barangayDetails->good_moral_fee ?? 30.00,
            'death_certificate' => $barangayDetails->death_cert_fee ?? 50.00,
            'jobseeker' => $barangayDetails->jobseeker_fee ?? 0.00,
        ];

        return $fees[$documentType] ?? 0;
    }
}
