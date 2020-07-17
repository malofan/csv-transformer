<?php

declare(strict_types=1);

namespace Spot\Transformer\FromSales\Badm;

use DateTimeImmutable;
use Spot\DTO\DeliveryRecord;
use Spot\Exception\InvalidRecordException;
use Spot\ExportReportTypes;

class ToDelivery extends FromBadm
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return [
            'Склад/филиал',
            'Код подразд кл',
            'Дата накл',
            'Код товара',
            'Количество'
        ];
    }

    /**
     * @param mixed[] $record
     */
    protected function transformRecord(array $record): DeliveryRecord
    {
        return new DeliveryRecord(
            $this->getDistributorIdBy($record['Склад/филиал']),
            $record['Код подразд кл'],
            DateTimeImmutable::createFromFormat('d.m.Y', $record['Дата накл']) ?: null,
            $record['Код товара'],
            (float)$record['Количество'],
            0,
            null
        );
    }

    /**
     * @param mixed[] $record
     * @throws InvalidRecordException
     */
    public function transform(array $record): DeliveryRecord
    {
        return parent::transform($record);
    }

    public function getType(): string
    {
        return ExportReportTypes::DELIVERY;
    }
}
