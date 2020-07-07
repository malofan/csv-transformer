<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\FileMetaData\Sales;

use Spot\FileMetaData\Sales\OptimaSales;
use PHPUnit\Framework\TestCase;

class OptimaSalesTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new OptimaSales())->supports('optima', 'sales'));
    }
}
