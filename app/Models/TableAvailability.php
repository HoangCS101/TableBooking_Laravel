<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableAvailability extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'table_id', 'guest_name', 'pnum', 'date', 'time_slot'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}