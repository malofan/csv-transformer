<?php

declare(strict_types=1);

namespace Spot\Transformer\FromSales\Optima;

use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;
use Spot\Transformer\FromSales\FromSalesTransformer;

abstract class FromOptima extends FromSalesTransformer
{
    public function getPartnerType(): string
    {
        return PartnerTypes::OPTIMA;
    }

    protected function getDistributorIdBy($name): int
    {
        return $this->distributorRepository->getIdBy(
            $name,
            PartnerTypes::OPTIMA,
            FileMetaDataStrategy::REPORT_TYPE_SALES
        );
    }
}
