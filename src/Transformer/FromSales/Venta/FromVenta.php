<?php

declare(strict_types=1);

namespace Spot\Transformer\FromSales\Venta;

use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;
use Spot\Transformer\FromSales\FromSalesTransformer;

abstract class FromVenta extends FromSalesTransformer
{
    public function getPartnerType(): string
    {
        return PartnerTypes::VENTA;
    }

    protected function getDistributorIdBy(string $name): int
    {
        return $this->distributorRepository->getIdBy(
            $name,
            PartnerTypes::VENTA,
            FileMetaDataStrategy::REPORT_TYPE_SALES
        );
    }
}
