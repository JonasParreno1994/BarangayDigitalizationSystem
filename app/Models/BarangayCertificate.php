<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangayCertificate extends Model
{
    use SoftDeletes;

    protected $table = 'barangay_certificates';
    protected $fillable = [
        'resident_id',
        'purpose',
        'residence_period_months',
        'residence_period_years', 
        'cedula_number',
        'date_of_issuance',
        'or_number',
        'amount_paid',
        'status',
        'remarks'
    ];

    protected $casts = [
        'date_of_issuance' => 'date',
        'amount_paid' => 'decimal:2',
        'residence_period_months' => 'integer',
        'residence_period_years' => 'integer'
    ];

    public function resident()
    {
        return $this->belongsTo(ResidentModel::class, 'resident_id');
    }
}