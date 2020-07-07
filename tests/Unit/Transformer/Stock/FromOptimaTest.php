<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Stock;

use ArrayIterator;
use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\Stock\FromOptimaData;
use PHPUnit\Framework\TestCase;

class FromOptimaTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue(
            (new FromOptimaData($this->createMock(DistributorRepository::class)))->supports('optima', 'stock')
        );
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromOptimaData($this->createMock(DistributorRepository::class)))->transform([1, 2, 3], [1, 2, 3])->current(
        );
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

        $repo = $this->createMock(DistributorRepository::class);
        $repo->method('getIdBy')->willReturn(10);

        /** @var StockRecord $stockRecord */
        $stockRecord = (new FromOptimaData($repo))->transformAll(new ArrayIterator($records))->current();

        $this->assertInstanceOf(StockRecord::class, $stockRecord);
        $this->assertSame(10, $stockRecord->distributorId);
        $this->assertSame(336, $stockRecord->qty);
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
        self::assertSame('stock', (new FromOptimaData($this->createMock(DistributorRepository::class)))->getType());
    }
}
