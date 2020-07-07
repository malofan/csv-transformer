<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Writer;

use PHPUnit\Framework\TestCase;
use Spot\Writer\Ttoptions;

class TtoptionsTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue(Ttoptions::supports('ttoptions'));
    }
}
