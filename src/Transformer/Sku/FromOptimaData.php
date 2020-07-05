<?php

declare(strict_types=1);

namespace Spot\Transformer\Sku;

use Spot\DTO\SkuRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;
use Spot\Transformer\FromPartnerData;
use Spot\Transformer\TransformerStrategy;

class FromOptimaData extends FromPartnerData implements TransformerStrategy, ToSkuDataTransformer
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return ['Филиал', 'Код товара', 'Товар'];
    }

    /**
     * @param mixed[] $record
     */
    protected function transformRecord(array $record): SkuRecord
    {
        preg_match('/(.+)\((\d+)\)/', $record['Дебитор доставки'], $erpCodeMatch);

        return new SkuRecord(
            $this->distributorRepository->getIdBy(
                $record['Филиал'],
                PartnerTypes::OPTIMA,
                FileMetaDataStrategy::REPORT_TYPE_SALES
            ),
            $record['Код товара'],
            $record['Товар'],
            null,
            null,
            null
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

    public function supports(string $partnerType): bool
    {
        return PartnerTypes::OPTIMA === $partnerType;
    }
}
