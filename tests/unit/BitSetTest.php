<?php
declare(strict_types=1);

namespace Pwm\BitSet;

use PHPUnit\Framework\TestCase;

class BitSetTest extends TestCase
{
    /**
     * @test
     */
    public function get_values_from_bit_set(): void
    {
        self::assertSame([], BitSet::get(0b0));
        self::assertSame([0b1], BitSet::get(0b1));
        self::assertSame([0b1, 0b10], BitSet::get(0b11));
        self::assertSame([0b1, 0b100], BitSet::get(0b101));
        self::assertSame([0b1, 0b10, 0b100], BitSet::get(0b111));
    }

    /**
     * @test
     */
    public function set_bit_set_from_values(): void
    {
        self::assertSame(0b0, BitSet::set([]));
        self::assertSame(0b1, BitSet::set([0b1]));
        self::assertSame(0b11, BitSet::set([0b1, 0b10]));
        self::assertSame(0b101, BitSet::set([0b1, 0b100]));
        self::assertSame(0b111, BitSet::set([0b1, 0b10, 0b100]));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider provideMultiValuedBitArrays
     */
    public function set_does_not_work_with_multi_bit_values(array $multiBitValues): void
    {
        BitSet::set($multiBitValues);
    }

    /**
     * @test
     */
    public function set_value_order_does_not_matter(): void
    {
        self::assertSame(BitSet::set([0b1, 0b10, 0b100]), BitSet::set([0b100, 0b1, 0b10]));
    }

    /**
     * @test
     */
    public function add_values_to_bit_set(): void
    {
        self::assertSame(0b1, BitSet::add(0b0, [0b1]));
        self::assertSame(0b11, BitSet::add(0b1, [0b10]));
        self::assertSame(0b101, BitSet::add(0b1, [0b100]));
        self::assertSame(0b111, BitSet::add(0b0, [0b1, 0b10, 0b100]));
        self::assertSame(0b1111, BitSet::add(0b1010, [0b1, 0b100]));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider provideMultiValuedBitArrays
     */
    public function add_does_not_work_with_multi_bit_values(array $multiBitValues): void
    {
        BitSet::add(0b0, $multiBitValues);
    }

    /**
     * @test
     */
    public function add_value_order_does_not_matter(): void
    {
        self::assertSame(BitSet::add(0b0, [0b1, 0b10, 0b100]), BitSet::add(0b0, [0b100, 0b1, 0b10]));
    }

    /**
     * @test
     */
    public function adding_zero_has_no_effect(): void
    {
        self::assertSame(0b1, BitSet::add(0b1, [0b0]));
        self::assertSame(BitSet::add(0b10, [0b1]), BitSet::add(0b10, [0b0, 0b1]));
    }

    /**
     * @test
     */
    public function add_is_idempotent(): void
    {
        self::assertSame(BitSet::add(0b0, [0b1]), BitSet::add(BitSet::add(0b0, [0b1]), [0b1]));
    }

    /**
     * @test
     */
    public function remove_values_from_bit_set(): void
    {
        self::assertSame(0b0, BitSet::remove(0b1, [0b1]));
        self::assertSame(0b1, BitSet::remove(0b11, [0b10]));
        self::assertSame(0b10, BitSet::remove(0b11, [0b1]));
        self::assertSame(0b0, BitSet::remove(0b111, [0b1, 0b10, 0b100]));
        self::assertSame(0b1010, BitSet::remove(0b1111, [0b1, 0b100]));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider provideMultiValuedBitArrays
     */
    public function remove_does_not_work_with_multi_bit_values(array $multiBitValues): void
    {
        BitSet::remove(0b111, $multiBitValues);
    }

    /**
     * @test
     */
    public function remove_value_order_does_not_matter(): void
    {
        self::assertSame(BitSet::remove(0b111, [0b1, 0b10, 0b100]), BitSet::remove(0b111, [0b100, 0b1, 0b10]));
    }

    /**
     * @test
     */
    public function removing_zero_has_no_effect(): void
    {
        self::assertSame(0b1, BitSet::remove(0b1, [0b0]));
        self::assertSame(BitSet::remove(0b11, [0b1]), BitSet::remove(0b11, [0b0, 0b1]));
    }

    /**
     * @test
     */
    public function remove_is_idempotent(): void
    {
        self::assertSame(BitSet::remove(0b111, [0b10]), BitSet::remove(BitSet::remove(0b111, [0b10]), [0b10]));
    }

    /**
     * @test
     */
    public function has_checks_if_the_given_values_are_elements_of_the_bit_set(): void
    {
        self::assertTrue(BitSet::has(0b1, 0b1));
        self::assertFalse(BitSet::has(0b1, 0b10));

        self::assertTrue(BitSet::has(0b11, 0b1));
        self::assertTrue(BitSet::has(0b11, 0b10));
        self::assertFalse(BitSet::has(0b11, 0b100));

        self::assertTrue(BitSet::has(0b100, 0b100));
        self::assertFalse(BitSet::has(0b100, 0b1));
        self::assertFalse(BitSet::has(0b100, 0b10));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider provideMultiValuedBits
     */
    public function has_does_not_work_with_multi_bit_values(int $multiBitValue): void
    {
        BitSet::has(0b111, $multiBitValue);
    }

    /**
     * @test
     */
    public function zero_is_always_an_element(): void
    {
        self::assertTrue(BitSet::has(0b0, 0b0));
        self::assertTrue(BitSet::has(0b1, 0b0));
    }

    public function provideMultiValuedBitArrays(): array
    {
        return [
            [[0b11]],
            [[0b101]],
            [[0b1, 0b110]],
        ];
    }

    public function provideMultiValuedBits(): array
    {
        return [
            [0b11],
            [0b101],
        ];
    }
}
