<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableAvailability extends Model
{
    protected $fillable = [
        'table_id', 'date', 'start_time','end_time', 'guest_name', 'pnum'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}