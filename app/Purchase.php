<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['applied', 'user_id', 'cart_id', 'total_cost'];

    protected $casts = ['applied' => 'boolean'];

    /**
     * The buyer
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The cart containing the purchased products 
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    /**
     * Get the cart items, the "product slots"
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function items()
    {
        return $this->hasManyThrough(CartItem::class, Cart::class, 'id', 'cart_id');
    }

    /**
     * Get the products in the cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_items', 'cart_id', 'product_id', 'cart_id');
    }

    /**
     * Mark the product as used
     * 
     * @return void
     */
    public function applied()
    {
        $this->update(['applied' => true]);
    }
}
