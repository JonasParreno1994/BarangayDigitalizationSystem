<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Household extends Model
{
    protected $fillable = [
        'household_number',
        'region',
        'province',
        'city_municipality',
        'barangay',
        'household_address',
        'number_of_members',
        'status'
    ];

    public function members(): HasMany
    {
        return $this->hasMany(HouseholdMember::class);
    }

    public function householdHead()
    {
        return $this->hasOne(HouseholdMember::class)->where('is_head', true);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($household) {
            if (empty($household->household_number)) {
                $household->household_number = 'HH-' . str_pad(static::count() + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }
}
