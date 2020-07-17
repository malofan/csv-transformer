<?php

declare(strict_types=1);

namespace Spot\Transformer\FromStock\Optima;

use DateTimeImmutable;
use Spot\DTO\StockRecord;
use Spot\ExportReportTypes;

class ToStocks extends FromOptima
{
    /**
     * @param string[] $record
     */
    protected function createRecord(
        array $record,
        string $productCode,
        string $productName,
        int $index,
        string $distributorName
    ): StockRecord {
        return new StockRecord(
            $this->getDistributorIdBy($distributorName),
            new DateTimeImmutable(),
            $productCode,
            (int)$record[$index] + (int)$record[$index + 1],
            null,
            null,
            null
        );
    }

    public function getType(): string
    {
        return ExportReportTypes::STOCKS;
    }
}
