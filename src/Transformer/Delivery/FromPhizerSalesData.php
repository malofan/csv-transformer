<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use DateTimeImmutable;
use Spot\DTO\DeliveryRecord;

class FromPhizerSalesData implements ToDeliveryDataTransformer
{
    /**
     * @param mixed[] $record
     */
    public function transformRecord(array $record): DeliveryRecord
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
     * @param iterable $partnerRecords
     * @return DeliveryRecord[]
     */
    public function transformRecords(iterable $partnerRecords): iterable
    {
        foreach ($partnerRecords as $record) {
            yield $this->transformRecord($record);
        }
    }
}
