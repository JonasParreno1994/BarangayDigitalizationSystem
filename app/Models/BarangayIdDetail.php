<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayIdDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo1_path',
        'logo2_path',
        'heading1',
        'heading2',
        'heading3',
        'validity',
        'details',
        'pass_captain',
        'signature_path',
        'region',
        'province',
        'city_municipality',
        'barangay',
        'captain_name',
        'secretary_name'
    ];
}