<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayIdDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo1_path',
        'logo2_path',
        'heading1',
        'heading2',
        'heading3',
        'office_info',
        'ordinance_info',
        'validity',
        'details',
        'footer_text',
        'card_title',
        'back_header',
        'back_certification',
        'back_note',
        'back_loss_info',
        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_contact_address',
        'pass_captain',
        'signature_path',
        'region',
        'province',
        'city_municipality',
        'barangay',
        'captain_name',
        'secretary_name',
        'card_color_scheme',
        'include_fingerprint',
        'include_qr_code',
        'validity_years'
    ];

    protected $casts = [
        'include_fingerprint' => 'boolean',
        'include_qr_code' => 'boolean',
        'validity_years' => 'integer'
    ];

    // Helper method to get default values for new enhanced fields
    public static function getDefaultEnhancedData()
    {
        return [
            'office_info' => 'Office of the Punong Barangay',
            'ordinance_info' => 'Brgy. Ord. 001 S. of 2021 | SB Res. 2021-202',
            'footer_text' => 'ISSUED BASED UPON INFORMATION FURNISHED BY APPLICANT.',
            'card_title' => 'BARANGAY IDENTIFICATION CARD',
            'back_header' => 'THIS CARD IS NON-TRANSFERABLE',
            'back_certification' => 'This certifies that the person whose name and picture appear on the reverse side of this card is a bonafide resident of BARANGAY BACUYANGAN, MUNICIPALITY OF HINOBA-AN, NEGROS OCCIDENTAL.',
            'back_note' => 'NOTE: This card is valid only if SIGNED by the PUNONG BARANGAY.\n\nLoss of this card must be reported immediately to the Barangay Hall.',
            'back_loss_info' => 'Issued based upon information furnished by the applicant.',
            'emergency_contact_name' => 'ROSA NARCISO',
            'emergency_contact_number' => '09530538077',
            'emergency_contact_address' => 'ZONE 3, BRGY. BACUYANGAN, HINOBA-AN NEG. OCC.',
            'card_color_scheme' => 'blue',
            'include_fingerprint' => true,
            'include_qr_code' => true,
            'validity_years' => 3
        ];
    }
}