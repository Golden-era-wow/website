<?php

namespace App;

use App\Contracts\EmulatorContract;
use Illuminate\Database\Eloquent\Model;

class GameAccount extends Model
{
    protected $fillable = [
        'user_id', 'account_id', 'emulator'
    ];

    public static function link(Account $account, User $toUser)
    {
        return new static([
            'account_id' => $account->id,
            'user_id' => $toUser->id
        ]);
    }

    public function using(EmulatorContract $emulator)
    {
        return $this->fill([
            'emulator' => get_class($emulator)
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
