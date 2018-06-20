<?php

namespace App;

use App\ProductCategory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{	
    protected $fillable = [
    	'category',
    	'type',
    	'emulator',
    	'cost',
    	'photo_url',
    	'description',
    	'reference'
    ];

    protected $casts = [
    	'cost' => 'integer'
    ];

    /**
     * Get the character gear
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGear($query) 
    {
        return $query->where('category', ProductCategory::GEAR);
    } 

    /**
     * Get the character services
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeServices($query) 
    {
        return $query->where('category', ProductCategory::SERVICE);
    } 
}
