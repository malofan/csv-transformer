<?php

namespace Spot\Tests\Unit\FileMetaData;

use Spot\FileMetaData\VentaFileMetaData;
use PHPUnit\Framework\TestCase;

class VentaFileMetaDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new VentaFileMetaData())->supports('venta'));
    }
}
