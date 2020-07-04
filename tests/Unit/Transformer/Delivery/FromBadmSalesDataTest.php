<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Delivery;

use Spot\Exception\InvalidRecordException;
use Spot\Transformer\Delivery\FromBadmData;
use PHPUnit\Framework\TestCase;

class FromBadmSalesDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new FromBadmData())->supports('badm'));
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromBadmData())->transform([1, 2, 3]);
    }
}
