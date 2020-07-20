<?php

declare(strict_types=1);

namespace Spot\Transformer\FromSales\Badm;

use Spot\DTO\TtoptionsRecord;
use Spot\Exception\InvalidRecordException;
use Spot\ExportReportTypes;

class ToTtoptions extends FromBadm
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return [
            'Склад/филиал',
            'Код подразд кл',
            'Клиент',
            'Факт.адрес доставки',
            'ОКПО клиента',
            'Юр. адрес клиента',
        ];
    }

    /**
     * @param mixed[] $record
     */
    protected function transformRecord(array $record): TtoptionsRecord
    {
        return new TtoptionsRecord(
            $this->getDistributorIdBy($record['Склад/филиал']),
            $record['Код подразд кл'],
            $record['Клиент'],
            $record['Факт.адрес доставки'],
            $record['ОКПО клиента'],
            $record['Юр. адрес клиента']
        );
    }

    /**
     * @param mixed[] $record
     * @throws InvalidRecordException
     */
    public function transform(array $record): TtoptionsRecord
    {
        return parent::transform($record);
    }

    public function getType(): string
    {
        return ExportReportTypes::TTOPTIONS;
    }
}
