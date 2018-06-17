<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
    	'creator_id',
    	'photo_url',
    	'title',
    	'summary',
    	'body'
    ];

    public function creator()
    {
    	return $this->belongsTo(User::class, 'creator_id');
    }

    public function getLinkAttribute()
    {
        return route('news.show', $this);
    }
}
