<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purok extends Model
{
    use HasFactory;

    protected $fillable = [
        'purok_name',
        'description'
    ];

    
    public function residents(): HasMany
    {
        return $this->hasMany(ResidentModel::class);
    }
}