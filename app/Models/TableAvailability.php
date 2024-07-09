<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableAvailability extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'table_id', 'guest_name', 'pnum', 'date', 'timeslot_id', 'user_id',
        // here user_id is ID of the User who makes the booking, since one can make table reservation for someone else
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}