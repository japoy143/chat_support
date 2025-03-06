<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function chats()
    {
        return $this->belongsToMany(Chat::class);
    }
}
