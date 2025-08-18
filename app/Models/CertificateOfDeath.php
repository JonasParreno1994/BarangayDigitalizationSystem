<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateOfDeath extends Model
{
    use HasFactory;

    protected $table = 'certificate_of_death';
    protected $fillable = [
        'resident_id',
        'date_of_death',
        'place_of_death',
        'cause_of_death',
        'date_of_issuance',
        'certificate_number',
        'remarks',
        'status',
        'issued_by'
    ];

    protected $dates = ['date_of_death', 'date_of_issuance'];

    public function resident()
    {
        return $this->belongsTo(ResidentModel::class, 'resident_id');
    }
}