<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class HouseholdMember extends Model
{
    protected $fillable = [
        'household_id',
        'last_name',
        'first_name',
        'middle_name',
        'extension',
        'place_of_birth',
        'date_of_birth',
        'age',
        'sex',
        'civil_status',
        'citizenship',
        'occupation',
        'labor_employment_status',
        'relationship_to_head',
        'is_head'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_head' => 'boolean'
    ];

    public function household(): BelongsTo
    {
        return $this->belongsTo(Household::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->last_name}, {$this->first_name}" . ($this->middle_name ? " {$this->middle_name}" : '') . ($this->extension ? " {$this->extension}" : '');
    }

    public function getCalculatedAgeAttribute()
    {
        return $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : $this->age;
    }

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($member) {
            if ($member->date_of_birth) {
                $member->age = Carbon::parse($member->date_of_birth)->age;
            }
        });

        static::saved(function ($member) {
            $household = $member->household;
            $household->number_of_members = $household->members()->count();
            $household->save();
        });

        static::deleted(function ($member) {
            $household = $member->household;
            $household->number_of_members = $household->members()->count();
            $household->save();
        });
    }
}
