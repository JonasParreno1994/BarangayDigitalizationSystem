<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateOfIndigency extends Model
{
    use HasFactory;

    protected $table = 'certificate_of_indigency';
    protected $fillable = [
        'resident_id',
        'purpose',
        'status',
        'date_of_issuance',
        'or_number',
        'amount_paid',
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