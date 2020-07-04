<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Stock;

use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\Transformer\Stock\FromBadmData;
use PHPUnit\Framework\TestCase;

class FromBadmSalesDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new FromBadmData())->supports('badm'));
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromBadmData())->transform([1, 2, 3]);
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
            (new FromBadmData())->transformAll(new \ArrayIterator([$record]))->current()
        );
    }
}