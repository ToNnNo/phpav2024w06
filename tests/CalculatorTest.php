<?php

use PHPUnit\Framework\TestCase;
use App\Service\Calculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Calculator::class)]
class CalculatorTest extends TestCase
{
    protected Calculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    #[DataProvider('valuesProvider')]
    public function testAddition(int|float $expected, array $params): void
    {

        $this->assertEquals($expected, $this->calculator->addition(...$params));
    }

    public static function valuesProvider(): array
    {
        return [
            [0, []],
            [0, [0, 0]],
            [1, [1, 0]],
            [1, [0, 1]],
            [-1, [0, -1]],
            [0, [1, -1]],
            [2.4, [1.2, 1.2]],
            // [0.3, [0.1, 0.2]],
            [1, [1]],
            [0, [0]],
            [-1, [-1]],
            [15, [1, 2, 3, 4, 5]],
            [1, ['1']],
            [15, ['1', '2', '3', '4', '5']],
            [0, ['1', '-1']],
            [200, [1e2, 1e2]]
        ];
    }

    #[DataProvider('errorValuesProvider')]
    public function testAdditionException(array $params): void
    {
        $this->expectException(\TypeError::class);

        $this->calculator->addition(...$params);
    }

    public static function errorValuesProvider(): array
    {
        return [
            [[null]],
            [[null, null]],
            [[true]],
            [[2, true]],
            [[false]],
            [[10, 872, 72, false]],
            [["coucou"]],
            [[""]],
            [[new \stdClass()]],
        ];
    }
}
