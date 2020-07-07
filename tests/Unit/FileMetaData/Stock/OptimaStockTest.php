<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\FileMetaData;

use PHPUnit\Framework\TestCase;
use Spot\FileMetaData\Stock\OptimaStock;

class OptimaStockFileMetaDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new \Spot\FileMetaData\Stock\OptimaStock())->supports('optima', 'stock'));
    }
}
