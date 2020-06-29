<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use DateTimeImmutable;
use Spot\DTO\DeliveryRecord;
use Spot\PartnerTypes;

class FromVentaSalesData extends FromPartnerSalesData implements ToDeliveryDataTransformerStrategy
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return [
            'Склад',
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
            $record['Склад'],
            $record['UID пункта доставки'],
            DateTimeImmutable::createFromFormat('d.m.Y', $record['Дата накладной']) ?: null,
            $record['Код товара'],
            (float)$record['Количество'],
            null,
            null
        );
    }

    public function supports(string $partnerType): bool
    {
        return PartnerTypes::VENTA === $partnerType;
    }
}
