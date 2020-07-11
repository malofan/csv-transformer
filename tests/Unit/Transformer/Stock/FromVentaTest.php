<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Stock;

use ArrayIterator;
use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\Stock\FromVentaData;
use PHPUnit\Framework\TestCase;

class FromVentaTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue(
            (new FromVentaData($this->createMock(DistributorRepository::class)))->supports('venta', 'stock')
        );
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromVentaData($this->createMock(DistributorRepository::class)))->transform([1, 2, 3]);
    }

    /**
     * @test
     */
    public function transformAll(): void
    {
        $record = [
            'Наименование Препарата' => 'Наименование Препарата 1',
            'Код Мориона' => '123-hhg-8765',
            'Название Филиала' => '123.00',
            'Общий остаток' => '23'
        ];

        $repo = $this->createMock(DistributorRepository::class);
        $repo->method('getIdBy')->willReturn(10);
        /** @var StockRecord $stockRecord */
        $stockRecord = (new FromVentaData($repo))->transformAll(new ArrayIterator([$record]))->current();

        $this->assertInstanceOf(StockRecord::class, $stockRecord);
        $this->assertSame(10, $stockRecord->distributorId);
        $this->assertSame(123, $stockRecord->qty);
    }

    /**
     * @test
     */
    public function getPartnerType(): void
    {
        self::assertSame(
            'venta',
            (new FromVentaData($this->createMock(DistributorRepository::class)))->getPartnerType()
        );
    }

    /**
     * @test
     */
    public function getType(): void
    {
        self::assertSame('stocks', (new FromVentaData($this->createMock(DistributorRepository::class)))->getType());
    }
}
