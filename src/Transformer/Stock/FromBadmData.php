<?php

declare(strict_types=1);

namespace Spot\Transformer\Stock;

use DateTimeImmutable;
use Iterator;
use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;
use Spot\Transformer\FromPartnerData;
use Spot\Transformer\TransformerStrategy;

class FromBadmData extends FromPartnerData implements TransformerStrategy, ToStockDataTransformer
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
     * @return StockRecord[]
     * @throws InvalidRecordException
     */
    public function transformAll(Iterator $records): iterable
    {
        foreach ($records as $record) {
            yield $this->transform($record);
        }
    }

    /**
     * @param mixed[] $record
     * @throws InvalidRecordException
     */
    public function transform(array $record): StockRecord
    {
        return parent::transform($record);
    }

    public function supports(string $partnerType): bool
    {
        return PartnerTypes::BADM === $partnerType;
    }
}
