<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\FileMetaData;

use Spot\FileMetaData\Sales\OptimaSales;
use PHPUnit\Framework\TestCase;

class OptimaSalesFileMetaDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new OptimaSales())->supports('optima', 'sales'));
    }
}
