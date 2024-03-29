<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Delivery;

use Spot\Exception\InvalidRecordException;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\FromSales\Venta\ToDelivery;
use PHPUnit\Framework\TestCase;

class FromVentaTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new ToDelivery($this->createMock(DistributorRepository::class)))->supports('venta', 'sales'));
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
        self::assertSame('venta', (new ToDelivery($this->createMock(DistributorRepository::class)))->getPartnerType());
    }

    /**
     * @test
     */
    public function getType(): void
    {
        self::assertSame('delivery', (new ToDelivery($this->createMock(DistributorRepository::class)))->getType());
    }
}
