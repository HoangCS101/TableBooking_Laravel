<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'description', 'picture_url'
    ];

    public function availability()
    {
        return $this->hasMany(TableAvailability::class);
    }
}
