<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        // Location Information
        'region',
        'province',
        'city_municipality',
        'barangay_name',
        'district',
        'zip_code',
        'complete_address',
        
        // Official Information
        'captain_name',
        'captain_title',
        'secretary_name',
        'secretary_title',
        'treasurer_name',
        'treasurer_title',
        
        // Contact Information
        'barangay_contact',
        'barangay_email',
        'emergency_contact',
        'office_hours',
        
        // Header Information for Documents
        'heading1',
        'heading2',
        'heading3',
        'document_footer',
        
        // Logo and Signature Paths
        'logo1_path',
        'logo2_path',
        'municipal_logo_path',
        'captain_signature_path',
        'secretary_signature_path',
        
        // Certificate Settings
        'certificate_validity_period',
        'or_number_prefix',
        'document_series_prefix',
        
        // Fees
        'clearance_fee',
        'residency_fee',
        'indigency_fee',
        'good_moral_fee',
        'death_cert_fee',
        'jobseeker_fee',
        'id_replacement_fee',
        
        // Additional Information
        'barangay_established_date',
        'total_area',
        'total_population',
        'total_households',
        'barangay_classification',
        'income_classification',
        
        // Status
        'is_active'
    ];

    protected $casts = [
        'barangay_established_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the complete barangay address
     */
    public function getCompleteAddressAttribute()
    {
        return $this->complete_address ?: 
               "Barangay {$this->barangay_name}, {$this->city_municipality}, {$this->province}";
    }

    /**
     * Get formatted header for documents
     */
    public function getFormattedHeaderAttribute()
    {
        return [
            'line1' => $this->heading1 ?: 'REPUBLIC OF THE PHILIPPINES',
            'line2' => $this->heading2 ?: "{$this->province}, {$this->city_municipality}",
            'line3' => $this->heading3 ?: "BARANGAY {$this->barangay_name}"
        ];
    }

    /**
     * Get the main logo (logo1_path or fallback)
     */
    public function getMainLogoAttribute()
    {
        return $this->logo1_path;
    }

    /**
     * Get the secondary logo (logo2_path or municipal logo)
     */
    public function getSecondaryLogoAttribute()
    {
        return $this->logo2_path ?: $this->municipal_logo_path;
    }

    /**
     * Get fee for specific document type
     */
    public function getFee($documentType)
    {
        $fees = [
            'clearance' => $this->clearance_fee,
            'residency' => $this->residency_fee,
            'indigency' => $this->indigency_fee,
            'good_moral' => $this->good_moral_fee,
            'death_certificate' => $this->death_cert_fee,
            'jobseeker' => $this->jobseeker_fee,
        ];

        return $fees[$documentType] ?? 0;
    }

    /**
     * Get the active barangay details
     */
    public static function getActiveDetails()
    {
        return static::where('is_active', true)->first() ?: static::first();
    }
}
