<?php

declare(strict_types=1);

namespace Spot\Transformer\FromSales\Badm;

use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;
use Spot\Transformer\FromSales\FromSalesTransformer;

abstract class FromBadm extends FromSalesTransformer
{
    public function getPartnerType(): string
    {
        return PartnerTypes::BADM;
    }

    protected function getDistributorIdBy(string $name): int
    {
        return $this->distributorRepository->getIdBy(
            $name,
            PartnerTypes::BADM,
            FileMetaDataStrategy::REPORT_TYPE_SALES
        );
    }
}
