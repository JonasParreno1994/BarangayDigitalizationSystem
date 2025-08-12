<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationFooter extends Model
{
    use HasFactory;

    protected $fillable = [
        'picture1',
        'logo1',
        'logo1description',
        'logo2',
        'logo2description',
        'logo3',
        'logo3description'
    ];
}