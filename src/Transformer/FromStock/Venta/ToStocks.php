<?php

declare(strict_types=1);

namespace Spot\Transformer\FromStock\Venta;

use DateTimeImmutable;
use Iterator;
use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\ExportReportTypes;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;

class ToStocks extends FromVenta
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

    public function getType(): string
    {
        return ExportReportTypes::STOCKS;
    }

    /**
     * @param string[] $record
     */
    protected function createRecord(array $record, int $distributorId, int $qty): StockRecord
    {
        return new StockRecord(
            $distributorId,
            new DateTimeImmutable(),
            $record['Наименование Препарата'],
            $qty,
            null,
            null,
            null
        );
    }
}
