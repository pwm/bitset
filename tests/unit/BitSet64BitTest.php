<?php
declare(strict_types=1);

namespace Pwm\BitSet;

use PHPUnit\Framework\TestCase;

class BitSet64BitTest extends TestCase
{
    /**
     * @test
     */
    public function setting_all_64_bits_result_in_the_max_signed_integer_on_64_bit_systems(): void
    {
        $b64a = [
            BitSet::B0,  BitSet::B1,  BitSet::B2,  BitSet::B3,
            BitSet::B4,  BitSet::B5,  BitSet::B6,  BitSet::B7,
            BitSet::B8,  BitSet::B9,  BitSet::B10, BitSet::B11,
            BitSet::B12, BitSet::B13, BitSet::B14, BitSet::B15,
            BitSet::B16, BitSet::B17, BitSet::B18, BitSet::B19,
            BitSet::B20, BitSet::B21, BitSet::B22, BitSet::B23,
            BitSet::B24, BitSet::B25, BitSet::B26, BitSet::B27,
            BitSet::B28, BitSet::B29, BitSet::B30, BitSet::B31,
            BitSet::B32, BitSet::B33, BitSet::B34, BitSet::B35,
            BitSet::B36, BitSet::B37, BitSet::B38, BitSet::B39,
            BitSet::B40, BitSet::B41, BitSet::B42, BitSet::B43,
            BitSet::B44, BitSet::B45, BitSet::B46, BitSet::B47,
            BitSet::B48, BitSet::B49, BitSet::B50, BitSet::B51,
            BitSet::B52, BitSet::B53, BitSet::B54, BitSet::B55,
            BitSet::B56, BitSet::B57, BitSet::B58, BitSet::B59,
            BitSet::B60, BitSet::B61, BitSet::B62, BitSet::B63,
        ];
        $max64bit = 0b111111111111111111111111111111111111111111111111111111111111111; // 2^63 − 1

        $bitSet = BitSet::set($b64a);
        self::assertSame($max64bit, $bitSet);
        self::assertSame(0b0, BitSet::remove($bitSet, $b64a));
    }
}
