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

class FromOptimaData extends FromPartnerData implements TransformerStrategy, ToStockDataTransformer
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return [];
    }

    /**
     * @param string[] $record
     * @param string[] $header
     * @return StockRecord[]
     */
    protected function transformRecord(array $record, array $header = []): iterable
    {
        if (!in_array('Код товара', $header, true)) {
            throw InvalidRecordException::notProvidedField('Код товара');
        }

        $productCode = $record[array_search('Код товара', $header)];

        foreach ($header as $index => $fieldName) {
            if (in_array($fieldName, ['Товар', 'Код товара', 'Все', ''], true)) {
                continue;
            }

            yield new StockRecord(
                $fieldName,
                new DateTimeImmutable(),
                $productCode,
                (int)$record[$index] + (int)$record[$index + 1],
                null,
                null,
                null
            );
        }
    }

    public function transformAll(Iterator $records): iterable
    {
        $records->rewind();
        $header = $records->current();
        $records->next();
        $records->next(); // First record consist of meta data, so we skip it

        while ($records->valid()) {
            yield from $this->transform($records->current(), $header);

            $records->next();
        }
    }

    /**
     * @param string[] $record
     * @param string[] $header
     * @throws InvalidRecordException
     */
    public function transform(array $record, array $header = []): iterable
    {
        yield from $this->transformRecord($record, $header);
    }

    public function supports(string $partnerType): bool
    {
        return PartnerTypes::OPTIMA === $partnerType;
    }
}
