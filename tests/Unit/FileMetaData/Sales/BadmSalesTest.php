<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\FileMetaData;

use PHPUnit\Framework\TestCase;
use Spot\FileMetaData\Sales\BadmSales;

class BadmSalesTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new BadmSales())->supports('badm', 'sales'));
    }
}
