<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Delivery;

use Spot\Exception\InvalidRecordException;
use Spot\Transformer\Delivery\FromBadmSalesData;
use PHPUnit\Framework\TestCase;

class FromBadmSalesDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new FromBadmSalesData())->supports('badm'));
    }

    /**
     * @test
     */
    public function transform()
    {
        $this->expectException(InvalidRecordException::class);
        (new FromBadmSalesData())->transform([1, 2, 3]);
    }
}
