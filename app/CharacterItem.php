<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterItem extends Model
{
    protected $fillable = ['item_guid', 'cost', 'photo_url', 'description'];
}
