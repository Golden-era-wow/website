<?php

namespace App;

use App\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{	
    use Searchable;

    protected $fillable = [
    	'category',
    	'type',
    	'emulator',
    	'cost',
    	'photo_url',
    	'description',
    	'reference',
        'total_sales'
    ];

    protected $casts = [
    	'cost' => 'integer',
        'total_sales' => 'integer'
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
    
    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'category' => $this->category,
            'type' => $this->type,
            'cost' => (int)$this->cost,
            'photo_url' => $this->photo_url,
            'description' => $this->description,

            'total_sales' => (int)$this->total_sales,
            'created_at' => $this->created_at->getTimestamp(),
        ];
    }
}
