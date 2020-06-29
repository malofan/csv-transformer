<?php

namespace Spot\Tests\Unit\Transformer\Delivery;

use Spot\Exception\InvalidRecordException;
use Spot\Transformer\Delivery\FromVentaSalesData;
use PHPUnit\Framework\TestCase;

class FromVentaSalesDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new FromVentaSalesData())->supports('venta'));
    }

    /**
     * @test
     */
    public function transform()
    {
        $this->expectException(InvalidRecordException::class);
        (new FromVentaSalesData())->transform([1, 2, 3]);
    }
}
