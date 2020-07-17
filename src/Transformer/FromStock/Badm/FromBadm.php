<?php

declare(strict_types=1);

namespace Spot\Transformer\FromStock\Badm;

use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\PartnerTypes;
use Spot\Transformer\FromStock\FromStockTransformer;

abstract class FromBadm extends FromStockTransformer
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
            FileMetaDataStrategy::REPORT_TYPE_STOCK
        );
    }
}
