<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComelecModel extends Model
{
    use HasFactory;

    protected $table = 'tblcomelec';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        
        'precinct_no',
        'no',
        'name',
        'barangay',
        'purok'
    ];
}
