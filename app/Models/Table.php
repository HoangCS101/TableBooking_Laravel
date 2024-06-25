<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'name',
    ];

    public function availability()
    {
        return $this->hasMany(TableAvailability::class);
    }
}
