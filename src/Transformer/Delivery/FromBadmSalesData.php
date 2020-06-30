<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use DateTimeImmutable;
use Spot\DTO\DeliveryRecord;
use Spot\Exception\InvalidRecordException;
use Spot\PartnerTypes;
use Spot\Transformer\FromPartnerSalesData;
use Spot\Transformer\TransformerStrategy;

class FromBadmSalesData extends FromPartnerSalesData implements TransformerStrategy, ToDeliveryDataTransformer
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
            $record['Склад/филиал'],
            $record['Код подразд кл'],
            DateTimeImmutable::createFromFormat('d.m.Y', $record['Дата накл']) ?: null,
            $record['Код товара'],
            (float)$record['Количество'],
            null,
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

    public function supports(string $partnerType): bool
    {
        return PartnerTypes::BADM === $partnerType;
    }
}
