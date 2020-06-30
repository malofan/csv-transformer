<?php

declare(strict_types=1);

namespace Spot\Writer;

use Spot\DTO\DeliveryRecord;

class Delivery extends Writer
{
    public const FILE_NAME = 'delivery.csv';

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return [
            'id дистрибьютора',
            'Код клиента ERP',
            'Дата',
            'Код продукта дистрибьютора',
            'Количество',
            'Сумма отгрузки',
            'Номер расходной накладной'
        ];
    }

    /**
     * @param DeliveryRecord $record phpcs:ignore
     */
    public function insertRecord($record): void // phpcs:ignore
    {
        $this->writer->insertOne(
            [
                $record->distributorId,
                $record->clientERPCode,
                ($record->date ? $record->date->format('Y.m.d') : null),
                $record->distributorProductCode,
                $record->qty,
                $record->shipmentAmount,
                $record->billNumber
            ]
        );
    }
}
