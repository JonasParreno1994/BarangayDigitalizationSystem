<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ResidentModel extends Model
{
    protected $table = 'tblresidents';
    protected $primaryKey = 'id';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'suffix',
        'birth_date',
        'birth_place',
        'sex',
        'civil_status',
        'religion',
        'citizenship',
        'address',
        'occupation',
        'contact_number',
        'email',
        'voter_status',
        'precinct_number',
        'education',
        'education_status',
        'household_number',
        'region',
        'province',
        'city_municipality',
        'barangay',
        'census_no',
        'profile_picture',
        'purok_id',
        'is_senior_citizen',
        'senior_citizen_id',
        'is_pwd',
        'pwd_id',
        'pwd_type',
        'is_solo_parent',
        'solo_parent_id',
        'number_of_children',
        'is_indigenous',
        'is_ofw',
        'ofw_country',
        'is_unemployed',
        'status',
        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_contact_address',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_senior_citizen' => 'boolean',
        'is_pwd' => 'boolean',
        'is_solo_parent' => 'boolean',
    ];
    
    public function getFullNameAttribute()
    {
        return "{$this->last_name}, {$this->first_name}" . ($this->middle_name ? " {$this->middle_name}" : '') . ($this->suffix ? " {$this->suffix}" : '');
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }

    public function barangayClearances()
    {
        return $this->hasMany(BarangayClearance::class, 'resident_id');
    }

    public function purok(): BelongsTo
    {
        return $this->belongsTo(Purok::class);
    }

    public function certificatesOfIndigency()
    {
        return $this->hasMany(CertificateOfIndigency::class, 'resident_id');
    }

    public function goodMoralCertificates()
    {
        return $this->hasMany(BarangayGoodMoralCertificate::class, 'resident_id');
    }

    public function certificatesOfResidency()
    {
        return $this->hasMany(CertificateOfResidency::class, 'resident_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'resident_id');
    }

    public function scopeSeniorCitizens($query)
    {
        return $query->where('is_senior_citizen', true);
    }

    public function scopePWDs($query)
    {
        return $query->where('is_pwd', true);
    }

    public function scopeSoloParents($query)
    {
        return $query->where('is_solo_parent', true);
    }
       public function deathCertificate()
    {
        return $this->hasOne(CertificateOfDeath::class, 'resident_id');
    }

    public function idEmergencyContact()
    {
        return $this->hasOne(IdEmergencyContact::class, 'resident_id');
    }
     public function scopeActive($query)
    {
        return $query->where('status', '!=', 'Deceased');
    }
    public function scopeDeceased($query)
    {
        return $query->where('status', 'Deceased');
    }
}