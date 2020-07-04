<?php

declare(strict_types=1);

namespace Spot\Writer;

use Spot\DTO\StockRecord;

class Stock extends Writer
{
    public const FILE_NAME = 'stocks.csv';

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
     * @param StockRecord[] $records
     */
    public function insertRecords(iterable $records): void
    {
        foreach ($records as $record) {
            $this->insertRecord($record);
        }
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
}
