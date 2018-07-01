<?php

namespace App;

class Faction
{
    public static function name(int $id)
    {
        $factions = [
            67 => 'Horde',
            469 => 'Alliance'
        ];

        return $factions[$id] ?? 'Unknown';
    }
}
