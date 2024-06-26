<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableAvailability extends Model
{
    protected $fillable = [
        'table_id', 'guest_name', 'pnum', 'date', 'start_time','end_time'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}