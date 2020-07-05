<?php

declare(strict_types=1);

namespace Spot\Transformer\Ttoptions;

use Spot\DTO\TtoptionsRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;
use Spot\Transformer\FromPartnerData;
use Spot\Transformer\TransformerStrategy;

class FromVentaData extends FromPartnerData implements TransformerStrategy, ToTtoptionsDataTransformer
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return [
            'Склад',
            'UID пункта доставки',
            'Клиент',
            'Адрес дост.',
            'ОКПО'
        ];
    }

    /**
     * @param mixed[] $record
     */
    protected function transformRecord(array $record): TtoptionsRecord
    {
        return new TtoptionsRecord(
            $this->distributorRepository->getIdBy(
                $record['Склад'],
                PartnerTypes::VENTA,
                FileMetaDataStrategy::REPORT_TYPE_SALES
            ),
            $record['UID пункта доставки'],
            $record['Клиент'],
            $record['Адрес дост.'],
            $record['ОКПО']
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
        return PartnerTypes::VENTA === $partnerType;
    }
}
