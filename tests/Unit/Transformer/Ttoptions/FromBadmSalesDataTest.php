<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Ttoptions;

use Spot\Exception\InvalidRecordException;
use Spot\Transformer\Ttoptions\FromBadmSalesData;
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
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromBadmSalesData())->transform([1, 2, 3]);
    }
}