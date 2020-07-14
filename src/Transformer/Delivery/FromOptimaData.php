<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use DateTimeImmutable;
use Spot\DTO\DeliveryRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;

class FromOptimaData extends ToDeliveryTransformer
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
            $this->distributorRepository->getIdBy(
                $record['Филиал'],
                PartnerTypes::OPTIMA,
                FileMetaDataStrategy::REPORT_TYPE_SALES
            ),
            $erpCodeMatch[1] ?? '',
            DateTimeImmutable::createFromFormat('d.m.Y', $record['День']) ?: null,
            $record['Код товара'],
            (float)$record['Продажи шт'],
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
        return PartnerTypes::OPTIMA;
    }
}
