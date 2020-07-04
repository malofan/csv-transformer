<?php

declare(strict_types=1);

namespace Spot\Transformer\Ttoptions;

use Spot\DTO\TtoptionsRecord;
use Spot\Exception\InvalidRecordException;
use Spot\PartnerTypes;
use Spot\Transformer\FromPartnerData;
use Spot\Transformer\TransformerStrategy;

class FromBadmData extends FromPartnerData implements TransformerStrategy, ToTtoptionsDataTransformer
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
            $record['Склад/филиал'],
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

    public function supports(string $partnerType): bool
    {
        return PartnerTypes::BADM === $partnerType;
    }
}
