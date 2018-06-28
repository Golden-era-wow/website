<?php

namespace App\Filters;

use App\Contracts\FilterContract;
use App\Filters\Concerns\FiltersDates;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;

abstract class QueryFilter implements FilterContract
{
    /**
     * The HTTP request containing the users requested filters.
     * 
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The Eloquent query.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    /**
     * Create a new QueryFilter instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->boot();
    }

    /**
     * Registered filters to operate upon.
     *
     * @var array
     * @return array
     */
    abstract public function filters();

    /**
     * Validation rules for the filters
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Initialize the query filter
     * 
     * @return void
     */
    public function boot()
    {
        $this->bootTraits();
    }

    /**
     * Boot all of the bootable traits on the query filter.
     *  
     * @return void
     */
    public function bootTraits()
    {
        foreach (class_uses_recursive($this) as $trait) {
            $method = 'boot'.class_basename($trait);

            if (method_exists($class, $method)) {
                $this->$method();
            }
        }
    }

    /**
     * Apply the filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query)
    {
        $this->query = $query;

        foreach ($this->requestedFilters() as $filter => $value) {
            $this->applyFilter($filter, $value);
        }

        return $this->query;
    }

    /**
     * Get the requested query filters 
     * 
     * @return array
     */
    public function requestedFilters()
    {
        return array_intersect_key(
            $this->request->input(), 
            array_flip($this->filters())
        );
    }

    /**
     * filter value using filter.
     *
     * @param string $filter
     * @param mixed  $value
     *
     * @return void
     */
    private function applyFilter($filter, $value)
    {
        if (method_exists($this, $filter)) {
            $this->$filter($value);
        } elseif (camel_case($filter) != $filter) {
            $this->applyFilter(camel_case($filter), $value);
        }
    }

    /**
     * Validate the filters
     *
     * @param \Illuminate\Contracts\Validation\Factory $factory
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Validation\Validator
     */
    public function validate($factory = null)
    {
        return tap($this->validator($factory), function ($validator) {
            $validator->validate();
        });
    }

    /**
     * Add our rules to a given or new validation factory instance.
     *
     * @param \Illuminate\Contracts\Validation\Factory $factory
     * @return \Illuminate\Validation\Validator
     */
    public function validator($factory = null)
    {
        if (is_null($factory)) {
            $factory = resolve(ValidationFactory::class);
        } 

        return $factory->make(
            $this->request->all(),
            $this->rules()
        );
    }
}