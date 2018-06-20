<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'cost'];

    /**
     * Get the cart slots that holds the given product
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query 
     * @param  \App\Product $product 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProduct($query, $product)
    {
        return $query->where('product_id', $product->id);
    } 

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
