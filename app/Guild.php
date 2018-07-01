<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Support\Carbon;
use App\Concerns\EmulatorDatabases;
use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    use EmulatorDatabases, Searchable;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'characters';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'guild';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'guildid';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the guilds with rank
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRank($query)
    {
        return $query->withCount('achievements as rank');
    }

    /**
     * Get guilds with the leaders faction
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithFaction($query)
    {
        // return $query->with(['leader.reputation' => function ($query) {
        //     $query->select(['faction']);
        // }]);

        return $query->selectSub('SELECT faction FROM character_reputation WHERE guild.leaderguid = guid', 'faction');
    }

    public function scopeRecent($query)
    {
        return $query
            ->whereDate('updatedDate', '=', Carbon::today()->toDateString())
            ->whereTime('updatedDate', '>=', Carbon::now()->subMinutes(15));
    }

    /**
     * The guilds achievements
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function achievements()
    {
        return $this->hasMany(GuildAchievement::class);
    }

    /**
     * The guild leader
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(Character::class, 'leaderguid');
    }

    /**
     * "cast" the faction id to a name
     *
     * @param integer $value
     * @return string
     */
    public function getFactionAttribute($value)
    {
        return Faction::name($value);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $realmCharacter = $this->realmCharacter;
        $realm = optional($realmCharacter)->realm;

        return [
            'name' => $this->name,
            'link' => url('guilds', $this),
            'leader' => optional($this->leader)->name,
            'faction' => $this->faction,
            'faction_banner_url' => Storage::url("factions/{$this->faction}.png"),
            'realm' => $realm ? $realm->name : 'Unknown',
            'level' => $this->level,
            'rank' => $this->rank,
            'info' => $this->info,
            'created_at' => $this->createdate,
            'updated_at' => Carbon::parse($this->updatedDate)->getTimestamp()
        ];
    }
}
