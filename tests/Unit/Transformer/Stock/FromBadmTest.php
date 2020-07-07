<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Stock;

use ArrayIterator;
use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\Stock\FromBadmData;
use PHPUnit\Framework\TestCase;

class FromBadmTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue(
            (new FromBadmData($this->createMock(DistributorRepository::class)))->supports('badm', 'stock')
        );
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromBadmData($this->createMock(DistributorRepository::class)))->transform([1, 2, 3]);
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
            (new FromBadmData($this->createMock(DistributorRepository::class)))->transformAll(
                new ArrayIterator([$record])
            )->current()
        );
    }

    /**
     * @test
     */
    public function getPartnerType(): void
    {
        self::assertSame('badm', (new FromBadmData($this->createMock(DistributorRepository::class)))->getPartnerType());
    }

    /**
     * @test
     */
    public function getType(): void
    {
        self::assertSame('stock', (new FromBadmData($this->createMock(DistributorRepository::class)))->getType());
    }
}
