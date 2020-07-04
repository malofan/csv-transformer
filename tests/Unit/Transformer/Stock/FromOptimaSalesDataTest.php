<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Stock;

use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\Transformer\Stock\FromOptimaData;
use PHPUnit\Framework\TestCase;

class FromOptimaSalesDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new FromOptimaData())->supports('optima'));
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromOptimaData())->transform([1, 2, 3], [1, 2, 3])->current();
    }

    /**
     * @test
     */
    public function transformAll(): void
    {
        $records = [
            ['Товар', 'Код товара', 'Название Филиала', '', 'Все'],
            ['Строка', 'c', 'названиями', 'столбцов'],
            ['БЕКОНАЗЕ СПРЕЙ 50МКГ/Д 180ДОЗ', '12654', '324.00', '12.00', '654.00']
        ];

        /** @var StockRecord $stockRecord */
        $stockRecord = (new FromOptimaData())->transformAll(new \ArrayIterator($records))->current();

        $this->assertInstanceOf(StockRecord::class, $stockRecord);
        $this->assertSame('Название Филиала', $stockRecord->distributorId);
        $this->assertSame(336, $stockRecord->qty);
    }
}
