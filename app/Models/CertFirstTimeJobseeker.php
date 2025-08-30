<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertFirstTimeJobseeker extends Model
{
    use HasFactory;
    protected $table = 'tbljobseeker';
    protected $fillable = [
        'resident_id',
        'age',
        'purok',
        'barangay',
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
    public function purok()
    {
        return $this->belongsTo(Purok::class, 'purok', 'purok_name');
    }
    
}
