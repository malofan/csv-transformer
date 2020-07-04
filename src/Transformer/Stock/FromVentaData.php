<?php

declare(strict_types=1);

namespace Spot\Transformer\Stock;

use DateTimeImmutable;
use Iterator;
use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\PartnerTypes;
use Spot\Transformer\FromPartnerData;
use Spot\Transformer\TransformerStrategy;

class FromVentaData extends FromPartnerData implements TransformerStrategy, ToStockDataTransformer
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
     */
    protected function transformRecord(array $record): iterable
    {
        foreach ($record as $fieldName => $value) {
            if (in_array($fieldName, ['Наименование Препарата', 'Код Мориона', 'Общий остаток'], true)) {
                continue;
            }

            yield new StockRecord(
                $fieldName,
                new DateTimeImmutable(),
                $record['Наименование Препарата'],
                (int)$value,
                null,
                null,
                null
            );
        }
    }

    public function transformAll(Iterator $records): iterable
    {
        foreach ($records as $record) {
            yield from $this->transform($record);
        }
    }

    /**
     * @param mixed[] $record
     * @throws InvalidRecordException
     */
    public function transform(array $record): iterable
    {
        return parent::transform($record);
    }

    public function supports(string $partnerType): bool
    {
        return PartnerTypes::VENTA === $partnerType;
    }
}