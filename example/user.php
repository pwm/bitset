<?php
declare(strict_types=1);

require __DIR__.'/vendor/autoload.php';

use Pwm\BitSet\BitSet;

class User
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
        // 32 bit max: 0b1000000000000000000000000000000
        // 64 bit max: 0b100000000000000000000000000000000000000000000000000000000000000
    ];

    private $groups = 0b0;

    public function getGroups(): array
    {
        return self::groupsFromBits(BitSet::get($this->groups));
    }

    public function setGroups(array $groups): void
    {
        $this->groups = BitSet::set(self::bitsFromGroups($groups));
    }

    public function addGroups(array $groups): void
    {
        $this->groups = BitSet::add($this->groups, self::bitsFromGroups($groups));
    }

    public function removeGroups(array $groups): void
    {
        $this->groups = BitSet::remove($this->groups, self::bitsFromGroups($groups));
    }

    public function hasGroup(string $group): bool
    {
        return BitSet::has($this->groups, self::bitsFromGroups([$group])[0]);
    }

    private static function bitsFromGroups($groups): array
    {
        return array_values(array_intersect_key(self::GROUPS, array_flip($groups)));
    }

    private static function groupsFromBits($groups): array
    {
        return array_values(array_intersect_key(array_flip(self::GROUPS), array_flip($groups)));
    }
}

$user = new User();
assert($user->getGroups() === []);
assert($user->hasGroup(User::G2) === false);

$user->setGroups([User::G1, User::G2]);
assert($user->getGroups() === [User::G1, User::G2]);
assert($user->hasGroup(User::G2) === true);

$user->addGroups([User::G4, User::G5]);
assert($user->getGroups() === [User::G1, User::G2, User::G4, User::G5]);
assert($user->hasGroup(User::G2) === true);
assert($user->hasGroup(User::G4) === true);

$user->removeGroups([User::G1, User::G4]);
assert($user->getGroups() === [User::G2, User::G5]);
assert($user->hasGroup(User::G2) === true);
assert($user->hasGroup(User::G4) === false);
