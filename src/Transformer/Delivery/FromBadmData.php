<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use DateTimeImmutable;
use Spot\DTO\DeliveryRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;

class FromBadmData extends ToDeliveryTransformer
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
            $this->distributorRepository->getIdBy(
                $record['Склад/филиал'],
                PartnerTypes::BADM,
                FileMetaDataStrategy::REPORT_TYPE_SALES
            ),
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

    public function getPartnerType(): string
    {
        return PartnerTypes::BADM;
    }
}
