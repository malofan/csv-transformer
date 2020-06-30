<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Delivery;

use Spot\Exception\InvalidRecordException;
use Spot\Transformer\Delivery\FromOptimaSalesData;
use PHPUnit\Framework\TestCase;

class FromOptimaSalesDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new FromOptimaSalesData())->supports('optima'));
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromOptimaSalesData())->transform([1, 2, 3]);
    }
}
