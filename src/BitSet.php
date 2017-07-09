<?php
declare(strict_types=1);

namespace Pwm\BitSet;

use InvalidArgumentException;

final class BitSet
{
    public static function get(int $bitSet): array
    {
        $values = [];
        $value = 0b1;
        while ($bitSet !== 0) {
            if (($bitSet & $value) > 0b0) {
                $values[] = $value;
                $bitSet &= ~$value;
            }
            $value <<= 0b1;
        }
        return $values;
    }

    public static function set(array $values): int
    {
        self::enforceSingleValues($values);
        $bitSet = 0b0;
        if (count($values) > 0) {
            foreach ($values as $value) {
                $bitSet |= $value;
            }
        }
        return $bitSet;
    }

    public static function add(int $bitSet, array $values): int
    {
        self::enforceSingleValues($values);
        return $bitSet | self::set($values);
    }

    public static function remove(int $bitSet, array $values): int
    {
        self::enforceSingleValues($values);
        return $bitSet & ~self::set($values);
    }

    public static function has(int $bitSet, int $value): bool
    {
        if ($value === 0b0) {
            return true;
        }
        self::enforceSingleValue($value);
        return ($bitSet & $value) > 0b0;
    }

    private static function enforceSingleValues(array $values): void
    {
        foreach ($values as $value) {
            self::enforceSingleValue($value);
        }
    }

    private static function enforceSingleValue(int $value): void
    {
        if (count(self::get($value)) > 1) {
            throw new InvalidArgumentException();
        }
    }
}
