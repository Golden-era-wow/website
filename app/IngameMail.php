<?php

namespace App;

use Illuminate\Support\Collection;

class IngameMail
{
    /**
     * Name of the ingame recipient
     *
     * @var string
     */
    public $to;

    /**
     * Briefly what the mail is about
     *
     * @var string
     */
    public $subject;

    /**
     * The message of the mail
     *
     * @var string
     */
    public $body;

    /**
     * A collection of items to be sent with the mail
     *
     * @var \Illuminate\Support\Collection | array
     */
    public $items;

    public function items()
    {
        return Collection::make($this->items)
            ->mapInto(Collection::class)
            ->map->implode(':');
    }

    public function toCommandString()
    {
        return "{$this->to} {$this->subject} {$this->body} {$this->items()->implode(' ')}";
    }

    public function __toString()
    {
        return $this->toCommandString();
    }
}
