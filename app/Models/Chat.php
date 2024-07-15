<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
