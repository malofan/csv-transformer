<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

use Spot\PartnerTypes;

final class OptimaStockFileMetaData extends BaseFileMetaDataInterface implements FileMetaDataStrategy
{
    /**
     * @return string[]
     */
    public function headerFields(): array
    {
        return ['Товар', 'Код товара', 'Все'];
    }

    public function headerOffset(): ?int
    {
        return null;
    }

    public function supports(string $partnerType, string $reportType = null): bool
    {
        return PartnerTypes::OPTIMA === $partnerType && FileMetaDataStrategy::REPORT_TYPE_STOCK === $reportType;
    }
}
