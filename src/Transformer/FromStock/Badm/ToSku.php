<?php

declare(strict_types=1);

namespace Spot\Transformer\FromStock\Badm;

use Spot\DTO\SkuRecord;
use Spot\Exception\InvalidRecordException;
use Spot\ExportReportTypes;

class ToSku extends FromBadm
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return [
            'Филиал',
            'Код товара',
            'Товар',
        ];
    }

    /**
     * @param mixed[] $record
     */
    protected function transformRecord(array $record): SkuRecord
    {
        return new SkuRecord(
            $this->getDistributorIdBy($record['Филиал']),
            $record['Код товара'],
            $record['Товар'],
            null,
            null,
            '1'
        );
    }

    /**
     * @param mixed[] $record
     * @throws InvalidRecordException
     */
    public function transform(array $record): SkuRecord
    {
        return parent::transform($record);
    }

    public function getType(): string
    {
        return ExportReportTypes::SKU;
    }
}
