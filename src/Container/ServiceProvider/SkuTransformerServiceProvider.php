<?php

declare(strict_types=1);

namespace Spot\Container\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Spot\Transformer\Sku\FromBadmSalesData;
use Spot\Transformer\Sku\FromOptimaSalesData;
use Spot\Transformer\Sku\FromVentaSalesData;
use Spot\Transformer\Sku\SkuTransformer;
use Spot\Transformer\Sku\ToSkuDataTransformer;

class SkuTransformerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        FromBadmSalesData::class,
        FromOptimaSalesData::class,
        FromVentaSalesData::class,
        SkuTransformer::class,
    ];

    public function register(): void
    {
        $this->getContainer()->add(FromBadmSalesData::class)->addTag(ToSkuDataTransformer::TAG_NAME);
        $this->getContainer()->add(FromOptimaSalesData::class)->addTag(ToSkuDataTransformer::TAG_NAME);
        $this->getContainer()->add(FromVentaSalesData::class)->addTag(ToSkuDataTransformer::TAG_NAME);
        $this->getContainer()->add(SkuTransformer::class)->addArgument(
            $this->getContainer()->get(ToSkuDataTransformer::TAG_NAME)
        );
    }
}
