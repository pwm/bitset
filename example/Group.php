<?php
declare(strict_types=1);

class Group
{
    const G1 = 'Group 1';
    const G2 = 'Group 2';
    const G3 = 'Group 3';
    const G4 = 'Group 4';
    const G5 = 'Group 5';

    const GROUPS = [
        self::G1 => 0b1,
        self::G2 => 0b10,
        self::G3 => 0b100,
        self::G4 => 0b1000,
        self::G5 => 0b10000,
        // max value for 32 bit systems: 0b1000000000000000000000000000000
        // max value for 64 bit systems: 0b100000000000000000000000000000000000000000000000000000000000000
    ];
}
