<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\FileMetaData\Stock;

use PHPUnit\Framework\TestCase;
use Spot\FileMetaData\Stock\OptimaStock;

class OptimaStockTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new OptimaStock())->supports('optima', 'stock'));
    }
}
