<?php
declare(strict_types=1);

use Pwm\BitSet\BitSet;

class Group
{
    const G1 = 'Group 1';
    const G2 = 'Group 2';
    const G3 = 'Group 3';
    const G4 = 'Group 4';
    const G5 = 'Group 5';

    private const MAP = [
        self::G1 => BitSet::B1,
        self::G2 => BitSet::B2,
        self::G3 => BitSet::B3,
        self::G4 => BitSet::B4,
        self::G5 => BitSet::B5,
    ];

    public static function fromGroups(array $groups): array
    {
        return array_values(array_intersect_key(self::MAP, array_flip($groups)));
    }

    public static function toGroups(array $bitValues): array
    {
        return array_values(array_intersect_key(array_flip(self::MAP), array_flip($bitValues)));
    }
}
