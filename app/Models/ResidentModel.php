<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResidentModel extends Model
{
    protected $table = 'tblresidents';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [

        'id',  
        'region',
        'city_municipality',
        'province',
        'barangay',
        'census_no',
        'last_name',
        'suffix',
        'first_name',
        'middle_name',
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
        'education',
        'education_status',
        'signature',
        'household_number',
        'voter_status',
        'voter_id',
        'precinct_number'
       
    ];



}

