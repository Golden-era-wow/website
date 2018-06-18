<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'purchase_id', 'amount', 'description'];

    protected $casts = ['amount' => 'integer'];

    /**
     * The user that has made the payment
     *
     * @return \\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The purchase the payment is cashed in for
     *
     * @return \\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
