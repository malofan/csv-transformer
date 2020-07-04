<?php

declare(strict_types=1);

namespace Spot\Transformer\Ttoptions;

use Spot\DTO\TtoptionsRecord;
use Spot\Exception\InvalidRecordException;
use Spot\PartnerTypes;
use Spot\Transformer\FromPartnerData;
use Spot\Transformer\TransformerStrategy;

class FromOptimaData extends FromPartnerData implements TransformerStrategy, ToTtoptionsDataTransformer
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return ['Филиал', 'Дебитор доставки', 'Фактический адрес', 'ОКПО'];
    }

    /**
     * @param mixed[] $record
     */
    protected function transformRecord(array $record): TtoptionsRecord
    {
        preg_match('/(.+)\((\d+)\)/', $record['Дебитор доставки'], $erpCodeMatch);

        return new TtoptionsRecord(
            $record['Филиал'],
            $erpCodeMatch[2] ?? '',
            trim($erpCodeMatch[1] ?? ''),
            $record['Фактический адрес'],
            $record['ОКПО'],
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
        return PartnerTypes::OPTIMA === $partnerType;
    }
}
