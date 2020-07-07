<?php

declare(strict_types=1);

namespace Spot\Container\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\Delivery\FromBadmData;
use Spot\Transformer\Delivery\FromOptimaData;
use Spot\Transformer\Delivery\FromVentaData;
use Spot\Transformer\TransformerStrategy;

class DeliveryTransformerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        FromBadmData::class,
        FromOptimaData::class,
        FromVentaData::class,
    ];

    public function register(): void
    {
        $this->getContainer()
            ->add(FromBadmData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(FromOptimaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(FromVentaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
    }
}
