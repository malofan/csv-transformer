<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Delivery;

use Spot\Exception\InvalidRecordException;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\FromSales\Optima\ToDelivery;
use PHPUnit\Framework\TestCase;

class FromOptimaTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue(
            (new \Spot\Transformer\FromSales\Optima\ToDelivery($this->createMock(DistributorRepository::class)))->supports('optima', 'sales')
        );
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new ToDelivery($this->createMock(DistributorRepository::class)))->transform([1, 2, 3]);
    }

    /**
     * @test
     */
    public function getPartnerType(): void
    {
        self::assertSame(
            'optima',
            (new ToDelivery($this->createMock(DistributorRepository::class)))->getPartnerType()
        );
    }

    /**
     * @test
     */
    public function getType(): void
    {
        self::assertSame('delivery', (new \Spot\Transformer\FromSales\Optima\ToDelivery($this->createMock(DistributorRepository::class)))->getType());
    }
}
