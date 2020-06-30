<?php

declare(strict_types=1);

namespace Spot\Container\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Spot\Transformer\Delivery\FromBadmSalesData;
use Spot\Transformer\Delivery\FromOptimaSalesData;
use Spot\Transformer\Delivery\FromVentaSalesData;
use Spot\Transformer\Delivery\DeliveryTransformer;
use Spot\Transformer\Delivery\ToDeliveryDataTransformer;

class DeliveryTransformerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        FromBadmSalesData::class,
        FromOptimaSalesData::class,
        FromVentaSalesData::class,
        DeliveryTransformer::class,
    ];

    public function register(): void
    {
        $this->getContainer()->add(FromBadmSalesData::class)->addTag(ToDeliveryDataTransformer::TAG_NAME);
        $this->getContainer()->add(FromOptimaSalesData::class)->addTag(ToDeliveryDataTransformer::TAG_NAME);
        $this->getContainer()->add(FromVentaSalesData::class)->addTag(ToDeliveryDataTransformer::TAG_NAME);
        $this->getContainer()->add(DeliveryTransformer::class)->addArgument(
            $this->getContainer()->get(ToDeliveryDataTransformer::TAG_NAME)
        );
    }
}
