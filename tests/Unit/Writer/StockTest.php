<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Writer;

use PHPUnit\Framework\TestCase;
use Spot\Writer\Stock;

class StockTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue(Stock::supports('stocks'));
    }
}
