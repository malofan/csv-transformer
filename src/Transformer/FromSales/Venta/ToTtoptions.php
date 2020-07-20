<?php

declare(strict_types=1);

namespace Spot\Transformer\FromSales\Venta;

use Spot\DTO\TtoptionsRecord;
use Spot\Exception\InvalidRecordException;
use Spot\ExportReportTypes;

class ToTtoptions extends FromVenta
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return [
            'Склад',
            'UID пункта доставки',
            'Клиент',
            'Адрес дост.',
            'ОКПО',
            'Адрес'
        ];
    }

    /**
     * @param mixed[] $record
     */
    protected function transformRecord(array $record): TtoptionsRecord
    {
        return new TtoptionsRecord(
            $this->getDistributorIdBy($record['Склад']),
            $record['UID пункта доставки'],
            $record['Клиент'],
            $record['Адрес дост.'],
            $record['ОКПО'],
            $record['Адрес']
        );
    }

    /**
     * @param mixed[] $record
     * @throws InvalidRecordException
     */
    public function transform(array $record): TtoptionsRecord
    {
        return parent::transform($record);
    }

    public function getType(): string
    {
        return ExportReportTypes::TTOPTIONS;
    }
}
