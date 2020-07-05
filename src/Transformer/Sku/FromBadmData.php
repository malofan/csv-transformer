<?php

declare(strict_types=1);

namespace Spot\Transformer\Sku;

use Spot\DTO\SkuRecord;
use Spot\Exception\InvalidRecordException;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;
use Spot\Transformer\FromPartnerData;
use Spot\Transformer\TransformerStrategy;

class FromBadmData extends FromPartnerData implements TransformerStrategy, ToSkuDataTransformer
{
    /**
     * @return string[]
     */
    protected function getRequiredRecordFields(): array
    {
        return [
            'Склад/филиал',
            'Код товара',
            'Товар',
            'Штрих-код товара',
        ];
    }

    /**
     * @param mixed[] $record
     */
    protected function transformRecord(array $record): SkuRecord
    {
        $barcode = strpos($record['Штрих-код товара'], 'E+') !== false
            ? sprintf('%d', str_replace(',', '.', $record['Штрих-код товара']))
            : $record['Штрих-код товара'];

        return new SkuRecord(
            $this->distributorRepository->getIdBy(
                $record['Склад/филиал'],
                PartnerTypes::BADM,
                FileMetaDataStrategy::REPORT_TYPE_SALES
            ),
            $record['Код товара'],
            $record['Товар'],
            $barcode,
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
        return PartnerTypes::BADM === $partnerType;
    }
}
