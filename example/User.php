<?php
declare(strict_types=1);

require_once __DIR__.'/../src/BitSet.php';

use Pwm\BitSet\BitSet;

class User
{
    private $groups = BitSet::EMPTY;

    public function getGroups(): array
    {
        return Group::toGroups(BitSet::get($this->groups));
    }

    public function setGroups(array $groups): void
    {
        $this->groups = BitSet::set(Group::fromGroups($groups));
    }

    public function addGroups(array $groups): void
    {
        $this->groups = BitSet::add($this->groups, Group::fromGroups($groups));
    }

    public function removeGroups(array $groups): void
    {
        $this->groups = BitSet::remove($this->groups, Group::fromGroups($groups));
    }

    public function hasGroup(string $group): bool
    {
        $a = Group::fromGroups([$group]);
        return isset($a[0])
            ? BitSet::has($this->groups, $a[0])
            : false;
    }
}
