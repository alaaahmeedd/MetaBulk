<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'names',
        'phones',
        'message'
     
    ];
    protected $casts = [
        'names' => 'array',
        'phones' => 'array'
        ];
    /**
     * Get the user that owns the archive.
     */
    public function user()
    {
        return $this->belongsTo(Archive::class);
    }
}
