<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangayGoodMoralCertificate extends Model
{
    use SoftDeletes;

    protected $table = 'barangay_good_moral_certificates';
    protected $fillable = [
        'resident_id',
        'purpose',
        'cedula_number',
        'date_of_issuance',
        'or_number',
        'amount_paid',
        'status',
        'remarks'
    ];

    protected $casts = [
        'date_of_issuance' => 'date',
        'amount_paid' => 'decimal:2'
    ];

    public function resident()
    {
        return $this->belongsTo(ResidentModel::class, 'resident_id');
    }
}