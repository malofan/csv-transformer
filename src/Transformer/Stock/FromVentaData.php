<?php

declare(strict_types=1);

namespace Spot\Transformer\Stock;

use DateTimeImmutable;
use Iterator;
use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;

class FromVentaData extends ToStockTransformer
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return ['Наименование Препарата', 'Код Мориона',];
    }

    /**
     * @param mixed[] $record
     * @return StockRecord[]
     */
    protected function transformRecord(array $record): iterable
    {
        foreach ($record as $fieldName => $value) {
            if (in_array($fieldName, ['Наименование Препарата', 'Код Мориона', 'Общий остаток'], true)) {
                continue;
            }

            yield new StockRecord(
                $this->distributorRepository->getIdBy(
                    $fieldName,
                    PartnerTypes::VENTA,
                    FileMetaDataStrategy::REPORT_TYPE_STOCK
                ),
                new DateTimeImmutable(),
                $record['Наименование Препарата'],
                (int)$value,
                null,
                null,
                null
            );
        }
    }

    /**
     * @param mixed[] $record
     * @return StockRecord[]
     * @throws InvalidRecordException
     */
    public function transform(array $record): iterable
    {
        return parent::transform($record);
    }

    /**
     * @return StockRecord[]
     * @throws InvalidRecordException
     */
    public function transformAll(Iterator $records): iterable
    {
        foreach ($records as $record) {
            yield from $this->transform($record);
        }
    }

    public function getPartnerType(): string
    {
        return PartnerTypes::VENTA;
    }
}
