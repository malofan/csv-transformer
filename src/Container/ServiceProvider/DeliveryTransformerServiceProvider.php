<?php

declare(strict_types=1);

namespace Spot\Container\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Spot\Transformer\Delivery\FromBadmData;
use Spot\Transformer\Delivery\FromOptimaData;
use Spot\Transformer\Delivery\FromVentaData;
use Spot\Transformer\Delivery\DeliveryTransformer;
use Spot\Transformer\Delivery\ToDeliveryDataTransformer;

class DeliveryTransformerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        FromBadmData::class,
        FromOptimaData::class,
        FromVentaData::class,
        DeliveryTransformer::class,
    ];

    public function register(): void
    {
        $this->getContainer()->add(FromBadmData::class)->addTag(ToDeliveryDataTransformer::TAG_NAME);
        $this->getContainer()->add(FromOptimaData::class)->addTag(ToDeliveryDataTransformer::TAG_NAME);
        $this->getContainer()->add(FromVentaData::class)->addTag(ToDeliveryDataTransformer::TAG_NAME);
        $this->getContainer()->add(DeliveryTransformer::class)->addArgument(
            $this->getContainer()->get(ToDeliveryDataTransformer::TAG_NAME)
        );
    }
}
