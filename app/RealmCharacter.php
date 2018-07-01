<?php

namespace App;

use App\Realm;
use App\Concerns\EmulatorDatabases;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RealmCharacter extends Pivot
{
    use EmulatorDatabases;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'auth';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'realmcharacters';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'realmid';

    public function realm()
    {
        return $this->belongsTo(Realm::class, 'realmid');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'acctid');
    }
}
