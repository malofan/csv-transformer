<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\FileMetaData\Stock;

use PHPUnit\Framework\TestCase;
use Spot\FileMetaData\Stock\VentaStock;

class VentaStockTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new VentaStock())->supports('venta', 'stock'));
    }
}
