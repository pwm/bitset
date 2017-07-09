<?php
declare(strict_types=1);

require_once __DIR__.'/../src/BitSet.php';

use Pwm\BitSet\BitSet;

class User
{
    private $groups = 0b0;

    public function getGroups(): array
    {
        return self::toGroups(BitSet::get($this->groups));
    }

    public function setGroups(array $groups): void
    {
        $this->groups = BitSet::set(self::fromGroups($groups));
    }

    public function addGroups(array $groups): void
    {
        $this->groups = BitSet::add($this->groups, self::fromGroups($groups));
    }

    public function removeGroups(array $groups): void
    {
        $this->groups = BitSet::remove($this->groups, self::fromGroups($groups));
    }

    public function hasGroup(string $group): bool
    {
        return BitSet::has($this->groups, self::fromGroups([$group])[0]);
    }

    private static function fromGroups(array $groups): array
    {
        return array_values(array_intersect_key(Group::GROUPS, array_flip($groups)));
    }

    private static function toGroups(array $values): array
    {
        return array_values(array_intersect_key(array_flip(Group::GROUPS), array_flip($values)));
    }
}
