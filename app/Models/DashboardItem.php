<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'image1_path',
        'image2_path',
        'image3_path',
        'image4_path',
        'image5_path',
        'description1',
        'description2',
        'description3',
        'description4',
        'description5'
    ];
}