<?php

declare(strict_types=1);

namespace Spot\Transformer\Sku;

use Spot\DTO\SkuRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;
use Spot\Transformer\FromPartnerData;
use Spot\Transformer\TransformerStrategy;

class FromVentaData extends FromPartnerData implements TransformerStrategy, ToSkuDataTransformer
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return ['Склад', 'Код товара', 'Товар'];
    }

    /**
     * @param mixed[] $record
     */
    protected function transformRecord(array $record): SkuRecord
    {
        return new SkuRecord(
            $this->distributorRepository->getIdBy(
                $record['Склад'],
                PartnerTypes::VENTA,
                FileMetaDataStrategy::REPORT_TYPE_SALES
            ),
            $record['Код товара'],
            $record['Товар'],
            null,
            null,
            '1 (штука)'
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
        return PartnerTypes::VENTA === $partnerType;
    }
}
