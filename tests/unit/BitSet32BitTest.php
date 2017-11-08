<?php
declare(strict_types=1);

namespace Pwm\BitSet;

use PHPUnit\Framework\TestCase;

class BitSet32BitTest extends TestCase
{
    /**
     * @test
     */
    public function setting_all_32_bits_result_in_the_max_signed_integer_on_32_bit_systems(): void
    {
        $b32a = [
            BitSet::B0,  BitSet::B1,  BitSet::B2,  BitSet::B3,
            BitSet::B4,  BitSet::B5,  BitSet::B6,  BitSet::B7,
            BitSet::B8,  BitSet::B9,  BitSet::B10, BitSet::B11,
            BitSet::B12, BitSet::B13, BitSet::B14, BitSet::B15,
            BitSet::B16, BitSet::B17, BitSet::B18, BitSet::B19,
            BitSet::B20, BitSet::B21, BitSet::B22, BitSet::B23,
            BitSet::B24, BitSet::B25, BitSet::B26, BitSet::B27,
            BitSet::B28, BitSet::B29, BitSet::B30, BitSet::B31,
        ];
        $max32bit = 0b1111111111111111111111111111111; // 2^31 − 1

        $bitSet = BitSet::set($b32a);
        self::assertSame($max32bit, $bitSet);
        self::assertSame(0b0, BitSet::remove($bitSet, $b32a));
    }
}
