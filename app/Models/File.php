<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $table = 'tblfiles';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'resident_id',
        'category_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'description',
        'upload_date'
    ];

    protected $casts = [
        'upload_date' => 'date',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(ResidentModel::class, 'resident_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FilesCategoryModel::class, 'category_id');
    }
}