<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameAccount extends Model
{
    protected $fillable = [
        'user_id', 'account_id', 'emulator'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
