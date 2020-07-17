<?php

declare(strict_types=1);

namespace Spot\Transformer\FromStock\Venta;

use Spot\DTO\SkuRecord;
use Spot\ExportReportTypes;

class ToSku extends FromVenta
{
    protected function createRecord(array $record, int $distributorId, int $qty)
    {
        return new SkuRecord(
            $distributorId,
            $record['Наименование Препарата'],
            $record['Наименование Препарата'],
            null,
            null,
            '1'
        );
    }

    public function getType(): string
    {
        return ExportReportTypes::SKU;
    }
}
