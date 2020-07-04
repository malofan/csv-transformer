<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Stock;

use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\Transformer\Stock\FromVentaData;
use PHPUnit\Framework\TestCase;

class FromVentaSalesDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new FromVentaData())->supports('venta'));
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromVentaData())->transform([1, 2, 3]);
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

        /** @var StockRecord $stockRecord */
        $stockRecord = (new FromVentaData())->transformAll(new \ArrayIterator([$record]))->current();

        $this->assertInstanceOf(StockRecord::class, $stockRecord);
        $this->assertSame('Название Филиала', $stockRecord->distributorId);
        $this->assertSame(123, $stockRecord->qty);
    }
}
