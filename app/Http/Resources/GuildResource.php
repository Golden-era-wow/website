<?php

namespace App\Http\Resources;

use App\Emulator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
        $guildLeader = Emulator::driver($request->input('emulator'))
            ->characters()
            ->table('characters')
            ->where('guid', $this->leaderguid)
            ->first();

        return [
            'name' => $this->name,
            'leader' => $this->when($guildLeader, optional($guildLeader)->name),
            'level' => $this->level,
            'rank' => $this->rank,
            'info' => $this->info,
            'created_at' => Carbon::createFromTimestamp($this->createdate)->format('Y-m-d H:i:s')
        ];
    }
}
