<?php

namespace App\Concerns\SkyFire;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait SendsIngameMails
{
    protected $mailStationery = [
        'normal' => 41,
        'GM' => 61,
        'auction' => 62
    ];

    /**
     * Send the items to the recipient character by ingame mail(s).
     *
     * @param string  $recipient
     * @param array   $items
     * @param integer $perMail
     *
     * @return void
     */
    public function sendItems($recipient, $items, $perMail = 8)
    {
        tap(DB::connection('skyfire_characters'), function ($database) use ($recipient, $items, $perMail) {
            $receiver = $this->findAccount($recipient);

            $mail = $database->table('mail')->insertGetId([
                'id' => $database->table('mail')->max('id') +1,
                'receiver' => $receiver->id,
                'subject' => trans('ingame_mails.items.subject'),
                'body' => trans('ingame_mails.items.body'),
                'stationery' => $this->mailStationery['GM'],
                'has_items' => true,

                'expire_time' => now()->addWeeks(2)->getTimestamp(),
                'deliver_time' => now()->getTimestamp(),
            ]);

            Collection::make($items)
                ->chunk($perMail)
                ->each(function ($items) use ($mail, $receiver, $database) {
                    $database->table('mail_items')->insert([
                        'mail_id' => $mail,
                        'receiver_id' => $receiver->id,
                        'item_guid' => $items
                    ]);
                });
        });
    }
}
