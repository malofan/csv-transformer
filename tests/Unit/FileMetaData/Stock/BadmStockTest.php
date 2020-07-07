<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\FileMetaData\Stock;

use PHPUnit\Framework\TestCase;
use Spot\FileMetaData\Stock\BadmStock;

class BadmStockTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new BadmStock())->supports('badm', 'stock'));
    }
}
