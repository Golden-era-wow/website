<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class GuildResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->guildid,
            'name' => $this->name,
            'link' => url('guilds', $this),
            'leader' => $this->whenLoaded('leader'),
            'faction' => $this->faction,
            'faction_banner_url' => Storage::url("factions/{$this->faction}.png"),
            'realm' => $this->whenLoaded('realmCharacter', function () {
                return $this->realmCharacter->realm->name;
            }),
            'level' => $this->level,
            'rank' => $this->rank,
            'info' => $this->info,
            'created_at' => $this->createdate,
            'updated_at' => Carbon::parse($this->updatedDate)->getTimestamp()
        ];
    }
}
