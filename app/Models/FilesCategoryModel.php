<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FilesCategoryModel extends Model
{
    protected $table = 'tblfilescategory';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'category_name'
    ];
}

