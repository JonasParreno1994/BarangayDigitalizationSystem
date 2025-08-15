<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertFirstTimeJobseeker extends Model
{
    // Define the table associated with the model
    protected $table = 'tbljobseeker';
    // Define the primary key for the model
    protected $primaryKey = 'id';
    use HasFactory;
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
    
}
