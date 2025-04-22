<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    protected $table = 'tblposition';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'position'
    ];

    public function officials(){
        return $this->hasMany(Official::class, 'position_id');
    }
}
