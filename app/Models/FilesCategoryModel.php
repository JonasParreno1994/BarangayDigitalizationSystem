<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FilesCategoryModel extends Model
{
    use HasFactory;
    
    protected $table = 'tblfilescategory';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'category_name'
    ];

    public function documents()
    {
        return $this->hasMany(Document::class, 'category_id');
    }
}