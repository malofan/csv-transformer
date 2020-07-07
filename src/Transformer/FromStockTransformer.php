<?php

declare(strict_types=1);

namespace Spot\Transformer;

use Spot\FileMetaData\FileMetaDataStrategy;

abstract class FromStockTransformer extends FromPartnerData implements TransformerStrategy
{
    public function supports(string $partnerType, string $reportType): bool
    {
        return $this->getPartnerType() === $partnerType && FileMetaDataStrategy::REPORT_TYPE_STOCK === $reportType;
    }
}
