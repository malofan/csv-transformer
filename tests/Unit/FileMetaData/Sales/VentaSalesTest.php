<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\FileMetaData\Sales;

use Spot\FileMetaData\Sales\VentaSales;
use PHPUnit\Framework\TestCase;

class VentaSalesTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new VentaSales())->supports('venta', 'sales'));
    }
}
