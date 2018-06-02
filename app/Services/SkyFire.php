<?php

namespace App\Services;

use App\IngameMail;
use Illuminate\Support\Collection;
use SoapClient;
use SoapParam;

class SkyFire
{
    /**
     * The SOAP client
     *
     * @var \SoapClient
     */
    protected $client;

    /**
     * Create a new SkyFire instance
     *
     * @param \SoapClient $client
     */
    public function __construct($client = null)
    {
        $this->client = $client ?? new SoapClient($wsdlUrl = null, config('services.skyfire'));
    }

    /**
     * Tell the underlying game server to create an account for given user.
     *
     * @param  \App\User $user
     * @param  string    $password
     * @return array
     */
    public function createAccount($user, $password)
    {
        return $this->dispatch("account create {$user->account_name} {$password}");
    }

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
        Collection::make($items)
            ->chunk($perMail)
            ->each(
                function ($items) use ($recipient) {
                    $mail = new IngameMail;
                    $mail->to = $recipient;
                    $mail->subject = trans('ingame_mails.items.subject');
                    $mail->body = trans('ingame_mails.items.body');
                    $mail->items = $items;

                    $this->dispatch("send items {$mail->toCommandString()}");
                }
            );
    }

    /**
     * Directly dispatch a command the underlying game server.
     *
     * @param  string $command
     * @return mixed
     */
    public function dispatch($command)
    {
        return $this->client->executeCommand(
            new SoapParam((string)$command, 'command')
        );
    }
}
