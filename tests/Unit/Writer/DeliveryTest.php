<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Writer;

use Spot\Writer\Delivery;
use PHPUnit\Framework\TestCase;

class DeliveryTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue(Delivery::supports('delivery'));
    }
}
