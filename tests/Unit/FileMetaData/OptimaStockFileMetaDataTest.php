<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\FileMetaData;

use PHPUnit\Framework\TestCase;
use Spot\FileMetaData\OptimaStockFileMetaData;

class OptimaStockFileMetaDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new OptimaStockFileMetaData())->supports('optima', 'stock'));
    }
}
