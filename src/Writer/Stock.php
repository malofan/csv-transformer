<?php

declare(strict_types=1);

namespace Spot\Writer;

use Spot\DTO\StockRecord;
use Spot\Transformer\Stock\ToStockTransformer;

class Stock extends BaseWriter
{
    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return [
            'id дистрибьютора',
            'Дата',
            'Код продукта дистрибьютора',
            'Количество',
            'Номер партии',
            'Годен до',
            'Дата производства',
        ];
    }

    /**
     * @param StockRecord $record phpcs:ignore
     */
    public function insertRecord($record): void // phpcs:ignore
    {
        $this->writer->insertOne(
            [
                $record->distributorId,
                $record->date->format('Y.m.d'),
                $record->distributorProductCode,
                $record->qty,
                $record->batchNumber,
                ($record->bestBefore ? $record->bestBefore->format('Y.m.d') : null),
                ($record->manufactureDate ? $record->manufactureDate->format('Y.m.d') : null),
            ]
        );
    }

    public static function supports(string $reportType): bool
    {
        return ToStockTransformer::TYPE === $reportType;
    }
}
