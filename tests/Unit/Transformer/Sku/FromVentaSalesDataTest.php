<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Sku;

use Spot\Exception\InvalidRecordException;
use Spot\Transformer\Sku\FromVentaSalesData;
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
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromVentaSalesData())->transform([1, 2, 3]);
    }
}
