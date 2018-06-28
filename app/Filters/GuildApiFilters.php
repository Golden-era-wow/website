<?php

namespace App\Filters;

class GuildApiFilters extends QueryFilter
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     * @return array
     */
    public function filters() 
    {
    	return ['latest'];
    }

    /**
     * Validation rules for the filters
     *
     * @return array
     */
    public function rules() 
    {
    	return ['latest' => 'nullable|string|in:level,rank,created_at'];
    }

    /**
     * Filter the underlying query
     * 
     * @param string|null $value
     * @return void
     */
    protected function latest($value)
    {
    	if (blank($value)) {
    		$this->query->latest('createdate');
    	} else {
    		$this->query->latest($value);
    	}
    }
}