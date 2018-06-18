<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['applied', 'user_id', 'cart_id', 'total_cost'];

    protected $casts = ['applied' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function items()
    {
        return $this->hasManyThrough(CartItem::class, Cart::class, 'id', 'cart_id');
    }

    public function applied()
    {
        $this->update(['applied' => true]);
    }
}
