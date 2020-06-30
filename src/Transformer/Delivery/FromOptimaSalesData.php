<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use DateTimeImmutable;
use Spot\DTO\DeliveryRecord;
use Spot\Exception\InvalidRecordException;
use Spot\PartnerTypes;
use Spot\Transformer\FromPartnerSalesData;
use Spot\Transformer\TransformerStrategy;

class FromOptimaSalesData extends FromPartnerSalesData implements TransformerStrategy, ToDeliveryDataTransformer
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
        return PartnerTypes::OPTIMA === $partnerType;
    }
}
