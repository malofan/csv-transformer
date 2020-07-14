<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use DateTimeImmutable;
use Spot\DTO\DeliveryRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;

class FromVentaData extends ToDeliveryTransformer
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return [
            'Склад',
            'UID пункта доставки',
            'Дата накладной',
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
            $this->distributorRepository->getIdBy(
                $record['Склад'],
                PartnerTypes::VENTA,
                FileMetaDataStrategy::REPORT_TYPE_SALES
            ),
            $record['UID пункта доставки'],
            DateTimeImmutable::createFromFormat('d.m.Y', $record['Дата накладной']) ?: null,
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

    public function getPartnerType(): string
    {
        return PartnerTypes::VENTA;
    }
}
