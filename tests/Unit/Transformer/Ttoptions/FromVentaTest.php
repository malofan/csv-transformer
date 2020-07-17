<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Ttoptions;

use Spot\Exception\InvalidRecordException;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\FromSales\Venta\ToTtoptions;
use PHPUnit\Framework\TestCase;

class FromVentaTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue(
            (new \Spot\Transformer\FromSales\Venta\ToTtoptions($this->createMock(DistributorRepository::class)))->supports('venta', 'sales')
        );
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new \Spot\Transformer\FromSales\Venta\ToTtoptions($this->createMock(DistributorRepository::class)))->transform([1, 2, 3]);
    }

    /**
     * @test
     */
    public function getPartnerType(): void
    {
        self::assertSame(
            'venta',
            (new ToTtoptions($this->createMock(DistributorRepository::class)))->getPartnerType()
        );
    }

    /**
     * @test
     */
    public function getType(): void
    {
        self::assertSame('ttoptions', (new \Spot\Transformer\FromSales\Venta\ToTtoptions($this->createMock(DistributorRepository::class)))->getType());
    }
}
