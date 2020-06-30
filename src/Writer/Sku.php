<?php

declare(strict_types=1);

namespace Spot\Writer;

use Spot\DTO\SkuRecord;

class Sku extends Writer
{
    public const FILE_NAME = 'sku.csv';

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return [
            'id дистрибьютора',
            'Код продукта дистрибьютора',
            'Название продукта',
            'Штрихкод',
            'Код продукта производителя',
            'id единицы измерения продукта',
        ];
    }

    /**
     * @param SkuRecord $record phpcs:ignore
     */
    public function insertRecord($record): void // phpcs:ignore
    {
        $this->writer->insertOne(
            [
                $record->distributorId,
                $record->distributorProductCode,
                $record->productName,
                $record->barcode,
                $record->manufacturerProductCode,
                $record->units,
            ]
        );
    }
}
