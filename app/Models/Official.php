<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    protected $fillable = [
        'name', 
        'position_id',
        'committee',
        'status'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}