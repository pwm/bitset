# Bit Set

A simple Bit Set implementation for efficient storage of sets of values.
The library itself is stateless and only provides the mapping functions.

## Requirements

PHP 7.1+

## Installation

    $ composer require pwm/bitset

## Usage

Let's have a `Group` class with group names and a map between names and binary values of powers of 2 starting with 2^0.

```php
class Group
{
    const G1 = 'Group 1';
    const G2 = 'Group 2';
    const G3 = 'Group 3';
    const G4 = 'Group 4';
    const G5 = 'Group 5';

    const GROUPS = [
        self::G1 => 0b1,     // 2^0
        self::G2 => 0b10,    // 2^1
        self::G3 => 0b100,   // 2^2
        self::G4 => 0b1000,  // 2^3
        self::G5 => 0b10000, // 2^4
    ];
}
```

Then let's have a `User` class. A user can belong to groups. The `$groups` property starts from binary 0.

```php
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
```

Now we can do:

```php
$user = new User();
assert($user->getGroups() === []);

$user->setGroups([Group::G1, Group::G2]);
assert($user->getGroups() === [Group::G1, Group::G2]);
assert($user->hasGroup(Group::G2) === true);

$user->addGroups([Group::G4, Group::G5]);
assert($user->getGroups() === [Group::G1, Group::G2, Group::G4, Group::G5]);
assert($user->hasGroup(Group::G4) === true);

$user->removeGroups([Group::G1, Group::G4]);
assert($user->getGroups() === [Group::G2, Group::G5]);
assert($user->hasGroup(Group::G2) === true);
assert($user->hasGroup(Group::G4) === false);
```

## Test

	$ vendor/bin/phpunit
