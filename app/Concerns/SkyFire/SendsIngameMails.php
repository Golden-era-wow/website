<?php

namespace App\Concerns\SkyFire;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait SendsIngameMails
{
    public $mailStationery = [
        'normal' => 41,
        'GM' => 61,
        'auction' => 62
    ];

    /**
     * Send the items to the recipient character by ingame mail(s).
     *
     * @param string $recipientCharacterGuid
     * @param array   $items
     * @param integer $perMail
     *
     * @return void
     */
    public function sendItems($recipientCharacterGuid, $items, $perMail = 8)
    {
        tap(DB::connection('skyfire_characters'), function ($database) use ($recipientCharacterGuid, $items, $perMail) {
            $mail = $database->table('mail')->insertGetId([
                'id' => $database->table('mail')->max('id') +1,
                'receiver' => $recipientCharacterGuid,
                'subject' => trans('ingame_mails.items.subject'),
                'body' => trans('ingame_mails.items.body'),
                'stationery' => $this->mailStationery['GM'],
                'has_items' => true,

                'expire_time' => now()->addWeeks(2)->getTimestamp(),
                'deliver_time' => now()->getTimestamp(),
            ]);

            Collection::make($items)
                ->chunk($perMail)
                ->eachSpread(function ($item) use ($mail, $recipientCharacterGuid, $database) {
                    $database->table('mail_items')->insert([
                        'mail_id' => $mail,
                        'receiver' => $recipientCharacterGuid,
                        'item_guid' => $item->item_guid
                    ]);
                });
        });
    }
}
