<?php

declare(strict_types=1);

namespace Spot\Transformer\FromStock\Venta;

use Iterator;
use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;
use Spot\Transformer\FromStock\FromStockTransformer;

abstract class FromVenta extends FromStockTransformer
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return ['Наименование Препарата',];
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

            yield $this->createRecord(
                $record,
                $this->distributorRepository->getIdBy(
                    $fieldName,
                    PartnerTypes::VENTA,
                    FileMetaDataStrategy::REPORT_TYPE_STOCK
                ),
                (int)$value
            );
        }
    }

    /**
     * @param string[] $record
     */
    abstract protected function createRecord(array $record, int $distributorId, int $qty); // phpcs:ignore

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
            if ($this->isEmptyRow($record)) {
                continue;
            }

            yield from $this->transform($record);
        }
    }

    public function getPartnerType(): string
    {
        return PartnerTypes::VENTA;
    }
}
