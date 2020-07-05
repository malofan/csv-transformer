<?php

declare(strict_types=1);

namespace Spot\Container\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\Stock\FromBadmData;
use Spot\Transformer\Stock\FromOptimaData;
use Spot\Transformer\Stock\FromVentaData;
use Spot\Transformer\Stock\StockTransformer;
use Spot\Transformer\Stock\ToStockDataTransformer;

class StockTransformerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        FromBadmData::class,
        FromOptimaData::class,
        FromVentaData::class,
        StockTransformer::class,
    ];

    public function register(): void
    {
        $this->getContainer()
            ->add(FromBadmData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(ToStockDataTransformer::TAG_NAME);
        $this->getContainer()
            ->add(FromOptimaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(ToStockDataTransformer::TAG_NAME);
        $this->getContainer()
            ->add(FromVentaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(ToStockDataTransformer::TAG_NAME);
        $this->getContainer()->add(StockTransformer::class)->addArgument(
            $this->getContainer()->get(ToStockDataTransformer::TAG_NAME)
        );
    }
}
