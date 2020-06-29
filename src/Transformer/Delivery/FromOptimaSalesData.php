<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use DateTimeImmutable;
use Spot\DTO\DeliveryRecord;
use Spot\PartnerTypes;

class FromOptimaSalesData extends FromPartnerSalesData implements ToDeliveryDataTransformerStrategy
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return [
            'Филиал',
            'Дебитор доставки',
            'День',
            'Код товара',
            'Продажи шт'
        ];
    }

    /**
     * @param mixed[] $record
     */
    protected function transformRecord(array $record): DeliveryRecord
    {
        preg_match('/\((\d+)\)/', $record['Дебитор доставки'], $erpCodeMatch);
        return new DeliveryRecord(
            $record['Филиал'],
            $erpCodeMatch[1] ?? '',
            DateTimeImmutable::createFromFormat('d.m.Y', $record['День']) ?: null,
            $record['Код товара'],
            (float)$record['Продажи шт'],
            null,
            null
        );
    }

    public function supports(string $partnerType): bool
    {
        return PartnerTypes::OPTIMA === $partnerType;
    }
}
