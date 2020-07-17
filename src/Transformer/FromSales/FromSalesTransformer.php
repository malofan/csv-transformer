<?php

declare(strict_types=1);

namespace Spot\Transformer\FromSales;

use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\Transformer\FromPartnerData;
use Spot\Transformer\TransformerStrategy;

abstract class FromSalesTransformer extends FromPartnerData implements TransformerStrategy
{
    public function supports(string $partnerType, string $reportType): bool
    {
        return $this->getPartnerType() === $partnerType && FileMetaDataStrategy::REPORT_TYPE_SALES === $reportType;
    }
}
