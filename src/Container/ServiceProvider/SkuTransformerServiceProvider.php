<?php

declare(strict_types=1);

namespace Spot\Container\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Spot\Transformer\Sku\FromBadmData;
use Spot\Transformer\Sku\FromOptimaData;
use Spot\Transformer\Sku\FromVentaData;
use Spot\Transformer\Sku\SkuTransformer;
use Spot\Transformer\Sku\ToSkuDataTransformer;

class SkuTransformerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        FromBadmData::class,
        FromOptimaData::class,
        FromVentaData::class,
        SkuTransformer::class,
    ];

    public function register(): void
    {
        $this->getContainer()->add(FromBadmData::class)->addTag(ToSkuDataTransformer::TAG_NAME);
        $this->getContainer()->add(FromOptimaData::class)->addTag(ToSkuDataTransformer::TAG_NAME);
        $this->getContainer()->add(FromVentaData::class)->addTag(ToSkuDataTransformer::TAG_NAME);
        $this->getContainer()->add(SkuTransformer::class)->addArgument(
            $this->getContainer()->get(ToSkuDataTransformer::TAG_NAME)
        );
    }
}
