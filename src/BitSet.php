<?php
declare(strict_types=1);

namespace Pwm\BitSet;

use InvalidArgumentException;

final class BitSet
{
    const EMPTY = self::B0;

    const B0  = 0b0; // 0
    const B1  = 0b1; // 2^0
    const B2  = 0b10; // 2^1
    const B3  = 0b100; // 2^2
    const B4  = 0b1000; // 2^3
    const B5  = 0b10000; // 2^4
    const B6  = 0b100000; // 2^5
    const B7  = 0b1000000; // 2^6
    const B8  = 0b10000000; // 2^7
    const B9  = 0b100000000; // 2^8
    const B10 = 0b1000000000; // 2^9
    const B11 = 0b10000000000; // 2^10
    const B12 = 0b100000000000; // 2^11
    const B13 = 0b1000000000000; // 2^12
    const B14 = 0b10000000000000; // 2^13
    const B15 = 0b100000000000000; // 2^14
    const B16 = 0b1000000000000000; // 2^15
    const B17 = 0b10000000000000000; // 2^16
    const B18 = 0b100000000000000000; // 2^17
    const B19 = 0b1000000000000000000; // 2^18
    const B20 = 0b10000000000000000000; // 2^19
    const B21 = 0b100000000000000000000; // 2^20
    const B22 = 0b1000000000000000000000; // 2^21
    const B23 = 0b10000000000000000000000; // 2^22
    const B24 = 0b100000000000000000000000; // 2^23
    const B25 = 0b1000000000000000000000000; // 2^24
    const B26 = 0b10000000000000000000000000; // 2^25
    const B27 = 0b100000000000000000000000000; // 2^26
    const B28 = 0b1000000000000000000000000000; // 2^27
    const B29 = 0b10000000000000000000000000000; // 2^28
    const B30 = 0b100000000000000000000000000000; // 2^29
    const B31 = 0b1000000000000000000000000000000; // 2^30 - limit on 32 bit systems
    const B32 = 0b10000000000000000000000000000000; // 2^31
    const B33 = 0b100000000000000000000000000000000; // 2^32
    const B34 = 0b1000000000000000000000000000000000; // 2^33
    const B35 = 0b10000000000000000000000000000000000; // 2^34
    const B36 = 0b100000000000000000000000000000000000; // 2^35
    const B37 = 0b1000000000000000000000000000000000000; // 2^36
    const B38 = 0b10000000000000000000000000000000000000; // 2^37
    const B39 = 0b100000000000000000000000000000000000000; // 2^38
    const B40 = 0b1000000000000000000000000000000000000000; // 2^39
    const B41 = 0b10000000000000000000000000000000000000000; // 2^40
    const B42 = 0b100000000000000000000000000000000000000000; // 2^41
    const B43 = 0b1000000000000000000000000000000000000000000; // 2^42
    const B44 = 0b10000000000000000000000000000000000000000000; // 2^43
    const B45 = 0b100000000000000000000000000000000000000000000; // 2^44
    const B46 = 0b1000000000000000000000000000000000000000000000; // 2^45
    const B47 = 0b10000000000000000000000000000000000000000000000; // 2^46
    const B48 = 0b100000000000000000000000000000000000000000000000; // 2^47
    const B49 = 0b1000000000000000000000000000000000000000000000000; // 2^48
    const B50 = 0b10000000000000000000000000000000000000000000000000; // 2^49
    const B51 = 0b100000000000000000000000000000000000000000000000000; // 2^50
    const B52 = 0b1000000000000000000000000000000000000000000000000000; // 2^51
    const B53 = 0b10000000000000000000000000000000000000000000000000000; // 2^52
    const B54 = 0b100000000000000000000000000000000000000000000000000000; // 2^53
    const B55 = 0b1000000000000000000000000000000000000000000000000000000; // 2^54
    const B56 = 0b10000000000000000000000000000000000000000000000000000000; // 2^55
    const B57 = 0b100000000000000000000000000000000000000000000000000000000; // 2^56
    const B58 = 0b1000000000000000000000000000000000000000000000000000000000; // 2^57
    const B59 = 0b10000000000000000000000000000000000000000000000000000000000; // 2^58
    const B60 = 0b100000000000000000000000000000000000000000000000000000000000; // 2^59
    const B61 = 0b1000000000000000000000000000000000000000000000000000000000000; // 2^60
    const B62 = 0b10000000000000000000000000000000000000000000000000000000000000; // 2^61
    const B63 = 0b100000000000000000000000000000000000000000000000000000000000000; // 2^62 - limit on 64 bit systems

    public static function get(int $bitSet): array
    {
        $values = [];
        $value = self::B1;
        while ($bitSet !== 0) {
            if (($bitSet & $value) > self::B0) {
                $values[] = $value;
                $bitSet &= ~$value;
            }
            $value <<= self::B1;
        }
        return $values;
    }

    public static function set(array $values): int
    {
        self::enforceSingleValues($values);
        $bitSet = self::B0;
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
        if ($value === self::B0) {
            return true;
        }
        self::enforceSingleValue($value);
        return ($bitSet & $value) > self::B0;
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
            throw new InvalidArgumentException('Individual bit values must be equal to powers of 2');
        }
    }
}
