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
        'province',
        'mun',
        'barangay',
        'purok',
        'philSysNo',
        'lastname',
        'firstname',
        'middlename',
        'suffix',
        'bdate',
        'bplace',
        'sex',
        'civilstatus',
        'religion',
        'residenceadd',
        'citizenship',
        'highesteducation',
        'name',
        'signature',
        'thumbmarkLeft',
        'thumbmarkRight',
        'attestedby',
        'householdNo',
        'createdat',
        'updatedat'

    ];


}

