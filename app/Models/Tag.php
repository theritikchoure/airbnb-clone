<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;
    
    use HasFactory;

    public function offices()
    {
        return $this->belongsToMany(Office::class, 'offices_tags');
    }
}
