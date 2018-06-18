<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $fillable = ['abandoned', 'purchased', 'purchasable_type', 'purchasable_id', 'user_id', 'deleted_at', 'created_at', 'updated_at'];

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

    public function add(Model $item)
    {
        return $this->items()->create([
            'purchasable_type' => get_class($item),
            'purchasable_id' => $item->getKey(),
            'cost' => $item->cost ?? 0
        ]);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function removeAll(Model $item)
    {
        $this->items()->purchasable($item)->delete();
    }

    public function remove(Model $item)
    {
        $this->items()->purchasable($item)->latest()->take(1)->delete();
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
