<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertIndigencyMinor extends Model
{
    use HasFactory;
    protected $table = 'cert__indigency__minor';
    protected $fillable = [
        'resident_id',
        'purpose',
        'purok',
        'childsName',
        'childsAge',
        'childsGender',
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
