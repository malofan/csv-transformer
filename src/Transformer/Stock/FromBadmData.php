<?php

declare(strict_types=1);

namespace Spot\Transformer\Stock;

use DateTimeImmutable;
use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;

class FromBadmData extends ToStockTransformer
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return [
            'Филиал',
            'Код товара',
            'Количество реальное',
            'Срок годности',
        ];
    }

    /**
     * @param mixed[] $record
     */
    protected function transformRecord(array $record): StockRecord
    {
        return new StockRecord(
            $this->distributorRepository->getIdBy(
                $record['Филиал'],
                PartnerTypes::BADM,
                FileMetaDataStrategy::REPORT_TYPE_STOCK
            ),
            new DateTimeImmutable(),
            $record['Код товара'],
            (int)$record['Количество реальное'],
            null,
            DateTimeImmutable::createFromFormat('d.m.Y', $record['Срок годности']),
            null
        );
    }

    /**
     * @param mixed[] $record
     * @throws InvalidRecordException
     */
    public function transform(array $record): StockRecord
    {
        return parent::transform($record);
    }

    public function getPartnerType(): string
    {
        return PartnerTypes::BADM;
    }
}
