<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'purok_id' 
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
    
    public function getFullNameAttribute(){
        return "{$this->last_name}, {$this->first_name}" . ($this->middle_name ? " {$this->middle_name}" : '') . ($this->suffix ? " {$this->suffix}" : '');
    }

    public function barangayClearances(){
        return $this->hasMany(BarangayClearance::class, 'resident_id');
    }

   
    public function purok(): BelongsTo{
        return $this->belongsTo(Purok::class);
    }

    public function certificatesOfIndigency(){
    return $this->hasMany(CertificateOfIndigency::class, 'resident_id');
    }

    public function goodMoralCertificates(){
    return $this->hasMany(BarangayGoodMoralCertificate::class, 'resident_id');
    }

    public function certificatesOfResidency(){
    return $this->hasMany(CertificateOfResidency::class, 'resident_id');
    }
}