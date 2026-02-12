<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_no',
        'complainants',
        'responders',
        'dispute_type',
        'nature_of_dispute',
        'mode_of_settlement',
        'action_taken',
    ];
}
