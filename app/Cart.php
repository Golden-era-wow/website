<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $fillable = ['abandoned', 'purchased', 'user_id', 'deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'abandoned' => 'boolean',
        'purchased' => 'boolean',
        'deleted_at' => 'datetime'
    ];

    /**
     * Find my available carts
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAvailable($query)
    {
        return $query
            ->where('abandoned', false)
            ->where('purchased', false);
    }

    /**
     * Scope carts with content
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotEmpty($query)
    {
        return $query->has('items');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, CartItem::class, 'cart_id');
    }

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function add($products)
    {
        Collection::wrap($products)->each(function ($product) {
            $this->items()->create([
                'product_id' => $product->id,
                'cost' => $product->cost ?? 0
            ]);
        });
    }

    public function removeAll(Product $product)
    {
        $this->items()->product($product)->delete();
    }

    public function remove(Product $product)
    {
        $this->items()->product($product)->latest()->take(1)->delete();
    }

    public function purchase()
    {
        $this->update([
            'abandoned' => false,
            'purchased' => true
        ]);
    }

    public function abandon()
    {
        $this->update([
            'abandoned' => true,
            'purchased' => true
        ]);
    }
}
