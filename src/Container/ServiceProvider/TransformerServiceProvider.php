<?php

declare(strict_types=1);

namespace Spot\Container\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\FromSales\Badm\ToDelivery as DeliverFromBadmData;
use Spot\Transformer\FromSales\Optima\ToDelivery as DeliverFromOptimaData;
use Spot\Transformer\FromSales\Venta\ToDelivery as DeliverFromVentaData;
use Spot\Transformer\FromSales\Badm\ToSku as SkuFromBadmData;
use Spot\Transformer\FromSales\Optima\ToSku as SkuFromOptimaData;
use Spot\Transformer\FromSales\Venta\ToSku as SkuFromVentaData;
use Spot\Transformer\FromStock\Badm\ToSku as SkuFromBadmStockData;
use Spot\Transformer\FromStock\Badm\ToStocks as StockFromBadmData;
use Spot\Transformer\FromStock\Optima\ToSku as SkuFromOptimaStockData;
use Spot\Transformer\FromStock\Optima\ToStocks as StockFromOptimaData;
use Spot\Transformer\FromStock\Venta\ToSku as SkuFromVentaStockData;
use Spot\Transformer\FromStock\Venta\ToStocks as StockFromVentaData;
use Spot\Transformer\TransformerProvider;
use Spot\Transformer\TransformerStrategy;
use Spot\Transformer\FromSales\Badm\ToTtoptions as TtoptionsFromBadmData;
use Spot\Transformer\FromSales\Optima\ToTtoptions as TtoptionsFromOptimaData;
use Spot\Transformer\FromSales\Venta\ToTtoptions as TtoptionsFromVentaData;

class TransformerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        TransformerProvider::class,
        DeliverFromBadmData::class,
        DeliverFromOptimaData::class,
        DeliverFromVentaData::class,
        SkuFromBadmData::class,
        SkuFromOptimaData::class,
        SkuFromVentaData::class,
        StockFromBadmData::class,
        StockFromOptimaData::class,
        StockFromVentaData::class,
        TtoptionsFromBadmData::class,
        TtoptionsFromOptimaData::class,
        TtoptionsFromVentaData::class,
        SkuFromBadmStockData::class,
        SkuFromOptimaStockData::class,
        SkuFromVentaStockData::class,
    ];

    public function register(): void
    {
        $this->getContainer()
            ->add(DeliverFromBadmData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(DeliverFromOptimaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(DeliverFromVentaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(SkuFromBadmData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(SkuFromOptimaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(SkuFromVentaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(StockFromBadmData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(StockFromOptimaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(StockFromVentaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(TtoptionsFromBadmData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(TtoptionsFromOptimaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(TtoptionsFromVentaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(SkuFromBadmStockData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(SkuFromOptimaStockData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);
        $this->getContainer()
            ->add(SkuFromVentaStockData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(TransformerStrategy::TAG_NAME);

        $this->getContainer()
            ->add(TransformerProvider::class)
            ->addArgument($this->getContainer()->get(TransformerStrategy::TAG_NAME));
    }
}
