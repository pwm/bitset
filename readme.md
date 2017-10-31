# BitSet

[![Build Status](https://travis-ci.org/pwm/bitset.svg?branch=master)](https://travis-ci.org/pwm/bitset)
[![codecov](https://codecov.io/gh/pwm/bitset/branch/master/graph/badge.svg)](https://codecov.io/gh/pwm/bitset)
[![Maintainability](https://api.codeclimate.com/v1/badges/8a9d4702ab0538377dfc/maintainability)](https://codeclimate.com/github/pwm/bitset/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/8a9d4702ab0538377dfc/test_coverage)](https://codeclimate.com/github/pwm/bitset/test_coverage)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

A simple bit set implementation for compact storage of sets of values. The library itself is stateless providing only pure mapping functions.

## Table of Contents

* [Requirements](#requirements)
* [Installation](#installation)
* [Usage](#usage)
* [How it works](#how-it-works)
* [Tests](#tests)
* [Changelog](#changelog)
* [Licence](#licence)

## Requirements

PHP 7.1+

## Installation

    $ composer require pwm/bitset

## Usage

In this example we are going to use a bit set to put users in groups.

Let's create a `Group` class. It has a list of groups, named G1 to G5 for this example, and a map between groups and binary values of powers of 2 provided by BitSet. Finally it has 2 functions that map between group names and bit values.

```php
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
```

Let's also create a `User` class. A user can belong to groups. The `$groups` property starts from 0 that represents the empty set. It has 5 methods to manipulate its groups, corresponding to BitSet's 5 functions: `get()`, `set()`, `add()`, `remove()` and `has()`.

```php
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
```

Now we can use the above the following way:

```php
$user = new User();
$user->setGroups([Group::G1, Group::G2]);

assert($user->getGroups() === [Group::G1, Group::G2]);
assert($user->hasGroup(Group::G1) === true);

$user->addGroups([Group::G4, Group::G5]);
$user->removeGroups([Group::G1, Group::G4]);

assert($user->getGroups() === [Group::G2, Group::G5]);
assert($user->hasGroup(Group::G1) === false);
```

## How it works

As an example let's take the numbers 1, 4 and 8. Their sum is 13. Pretty uninteresting so far. But let's look at their binary representations: 0b1, 0b100 and 0b1000 respectively. Their sum 13 is 0b1101. See how the base-2 representations of 1, 4 and 8 "fill unique slots" in 13's, leaving only one slot unset? This is because 1, 4 and 8 are all powers of 2 so their binary representations starts with a 1 followed by zero or more 0s. 0b1 = 2^0 = 1, 0b100 = 2^2 = 4, 0b1000 = 2^3 = 8. Their sum: 2^0 + 2^2 + 2^3 = 0b1 + 0b100 + 0b1000 = 0b1101 = 13. Now, say in a game, we could call 1 "north", 2 "south", 4 "east" and 8 "west" and then 13 could mean that our character can move all directions from its current position except south as 2 (0b10) is not in 13 (0b1101).

The idea behind a bit set is using a base-2 representation of a number to singal the presence or absence of values by having its bits set to 1 or 0. The values themselves are also numbers with the restriction that they must be powers of 2 starting from 2^0 and in general, depending on the underlying system, going up to 2^32 or 2^64. For example on a 64 bit system one can store up to 64 unique values in a bit set.

The `BitSet` library itself is a collection of 5 pure functions that map between values and their bit set:

`set(array $values): int`

Maps a list of unique positive integers to a single integer, the bit set, that is their sum. All integers in the input list must be powers of 2.

`get(int $bitSet): array`

Maps an integer, the bit set, to a list of unique positive integers. All integers in the output list must be powers of 2.

`add(int $bitSet, array $values): int`

Adds a list of unique positive integers to a bit set. All integers in the list must be powers of 2.

`remove(int $bitSet, array $values): int`

Subtracts a list of unique positive integers from a bit set. All integers in the list must be powers of 2.

`has(int $bitSet, int $value): bool`

Predicate that tells whether an element is in a bit set or not.

## Tests

	$ vendor/bin/phpunit
	$ composer phpcs
	$ composer phpstan

## Changelog

[Click here](changelog.md)

## Licence

[MIT](LICENSE)
