<?php

namespace App\Contracts;

interface EmulatorContract
{
    /**
     * Tell the underlying game server to create an account for given user.
     *
     * @param  \App\User $user
     * @param  string    $password
     * @return int
     */
    public function createAccount($user, $password);

    /**
     * Delete the skyfire account of given user.
     *
     * @param \App\User $user
     * @return bool
     */
    public function deleteAccount($user);

    /**
     * Find a game account
     *
     * @param \App\User|string $user
     * @return \App\GameAccount
     */
    public function findAccount($user);

    /**
     * Get the amount of online players
     *
     * @return integer
     */
    public function playerOnline();

    /**
     * Get the amount of active players
     *
     * @return int
     */
    public function playersActive();

    /**
     * Get the amount of inactive players
     *
     * @return int
     */
    public function playersInactive();

    /**
     * Get the amount of players created within last month
     *
     * @return int
     */
    public function playersRecentlyCreated();

    /**
     * Get the total amount of game accounts
     *
     * @return int
     */
    public function playersTotal();

    /**
     * Send the items to the recipient character by ingame mail(s).
     *
     * @param string  $recipient
     * @param array   $items
     * @param integer $perMail
     *
     * @return void
     */
    public function sendItems($recipient, $items, $perMail = 8);

    /**
     * Determine latency to the server by measuring the time spent on establishing a socket connection to the server
     *
     * @return null | integer
     */
    public function latency();
}
