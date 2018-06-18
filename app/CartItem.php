<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'purchasable_type', 'purchasable_id', 'cost'];

    public function scopePurchasable($query, $model)
    {
        return $query
            ->where('purchasable_type', get_class($model))
            ->where('purchasable_id', $model->getKey());
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function purchasable()
    {
        return $this->morphTo();
    }
}
