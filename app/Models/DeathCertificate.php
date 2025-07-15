<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'date_of_death',
        'time_of_death',
        'place_of_death',
        'cause_of_death',
        'civil_status_at_death',
        'purok',
        'date_of_issuance',
        'status',
        'remarks'
    ];

    protected $casts = [
        'date_of_death' => 'date',
        'date_of_issuance' => 'date',
    ];

    public function resident(){

    return $this->belongsTo(ResidentModel::class, 'resident_id');
    }

    public function purok(){

        return $this->belongsTo(Purok::class, 'purok', 'name');
    }

    public function barangayIdDetail()
    {
        return $this->belongsTo(BarangayIdDetail::class, 'barangay_id_detail_id');
    }

    public function official()
    {
        return $this->belongsTo(Official::class, 'official_id');
    }
}