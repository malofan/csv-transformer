<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\FileMetaData;

use Spot\FileMetaData\OptimaSalesFileMetaData;
use PHPUnit\Framework\TestCase;

class OptimaSalesFileMetaDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new OptimaSalesFileMetaData())->supports('optima', 'sales'));
    }
}
