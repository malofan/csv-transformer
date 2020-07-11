<?php

declare(strict_types=1);

namespace Spot\Transformer\Stock;

use DateTimeImmutable;
use Iterator;
use Spot\DTO\StockRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;

class FromOptimaData extends ToStockTransformer
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
                $this->distributorRepository->getIdBy(
                    $fieldName,
                    PartnerTypes::OPTIMA,
                    FileMetaDataStrategy::REPORT_TYPE_STOCK
                ),
                new DateTimeImmutable(),
                $productCode,
                (int)$record[$index] + (int)$record[$index + 1],
                null,
                null,
                null
            );
        }
    }

    /**
     * @return StockRecord[]
     * @throws InvalidRecordException
     */
    public function transformAll(Iterator $records): iterable
    {
        $records->rewind();
        $header = $records->current();
        $records->next();
        $records->next(); // First record consist of meta data, so we skip it

        while ($records->valid()) {
            if ($this->isEmptyRow($records->current())) {
                continue;
            }

            yield from $this->transform($records->current(), $header);

            $records->next();
        }
    }

    /**
     * @param string[] $record
     * @param string[] $header
     * @return StockRecord[]
     * @throws InvalidRecordException
     */
    public function transform(array $record, array $header = []): iterable
    {
        yield from $this->transformRecord($record, $header);
    }

    public function getPartnerType(): string
    {
        return PartnerTypes::OPTIMA;
    }
}
