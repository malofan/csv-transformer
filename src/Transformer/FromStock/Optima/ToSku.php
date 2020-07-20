<?php

declare(strict_types=1);

namespace Spot\Transformer\FromStock\Optima;

use Spot\DTO\SkuRecord;
use Spot\ExportReportTypes;

class ToSku extends FromOptima
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
    ): SkuRecord {
        return new SkuRecord($this->getDistributorIdBy($distributorName), $productCode, $productName, null, null, '1');
    }

    public function getType(): string
    {
        return ExportReportTypes::SKU;
    }
}
