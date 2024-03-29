<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Stock;

use ArrayIterator;
use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\FromStock\Badm\ToStocks;
use PHPUnit\Framework\TestCase;

class FromBadmTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new ToStocks($this->createMock(DistributorRepository::class)))->supports('badm', 'stock'));
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new ToStocks($this->createMock(DistributorRepository::class)))->transform([1, 2, 3]);
    }

    /**
     * @test
     */
    public function transformAll(): void
    {
        $record = [
            'Филиал' => 'Филиал 1',
            'Код товара' => '123-hhg-8765',
            'Количество реальное' => '12.0',
            'Срок годности' => '03.07.2020'
        ];

        $this->assertInstanceOf(
            StockRecord::class,
            (new ToStocks($this->createMock(DistributorRepository::class)))->transformAll(
                new ArrayIterator([$record])
            )->current()
        );
    }

    /**
     * @test
     */
    public function getPartnerType(): void
    {
        self::assertSame('badm', (new ToStocks($this->createMock(DistributorRepository::class)))->getPartnerType());
    }

    /**
     * @test
     */
    public function getType(): void
    {
        self::assertSame('stocks', (new ToStocks($this->createMock(DistributorRepository::class)))->getType());
    }
}
