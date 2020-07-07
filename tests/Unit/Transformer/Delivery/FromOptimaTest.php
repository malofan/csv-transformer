<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Delivery;

use Spot\Exception\InvalidRecordException;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\Delivery\FromOptimaData;
use PHPUnit\Framework\TestCase;

class FromOptimaSalesDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue(
            (new FromOptimaData($this->createMock(DistributorRepository::class)))->supports('optima', 'sales')
        );
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromOptimaData($this->createMock(DistributorRepository::class)))->transform([1, 2, 3]);
    }

    /**
     * @test
     */
    public function getPartnerType(): void
    {
        self::assertSame(
            'optima',
            (new FromOptimaData($this->createMock(DistributorRepository::class)))->getPartnerType()
        );
    }

    /**
     * @test
     */
    public function getType(): void
    {
        self::assertSame(
            'delivery',
            (new FromOptimaData($this->createMock(DistributorRepository::class)))->getType()
        );
    }
}
