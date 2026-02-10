<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdEmergencyContact extends Model
{
    protected $table = 'tblid_emergency_contacts';

    protected $fillable = [
        'resident_id',
        'contact_name',
        'contact_number',
        'contact_address',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(ResidentModel::class, 'resident_id');
    }
}
