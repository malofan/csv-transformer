<?php

declare(strict_types=1);

namespace Spot\Transformer\Ttoptions;

use Spot\DTO\TtoptionsRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;

class FromBadmData extends ToTtoptionsTransformer
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
            'ОКПО клиента'
        ];
    }

    /**
     * @param mixed[] $record
     */
    protected function transformRecord(array $record): TtoptionsRecord
    {
        return new TtoptionsRecord(
            $this->distributorRepository->getIdBy(
                $record['Склад/филиал'],
                PartnerTypes::BADM,
                FileMetaDataStrategy::REPORT_TYPE_SALES
            ),
            $record['Код подразд кл'],
            $record['Клиент'],
            $record['Факт.адрес доставки'],
            $record['ОКПО клиента']
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

    public function getPartnerType(): string
    {
        return PartnerTypes::BADM;
    }
}
