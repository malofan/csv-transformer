<?php

declare(strict_types=1);

namespace Spot\Container\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\Delivery\FromBadmData;
use Spot\Transformer\Delivery\FromOptimaData;
use Spot\Transformer\Delivery\FromVentaData;
use Spot\Transformer\Sku\FromBadmData as SkuFromBadmData;
use Spot\Transformer\Sku\FromOptimaData as SkuFromOptimaData;
use Spot\Transformer\Sku\FromVentaData as SkuFromVentaData;
use Spot\Transformer\Stock\FromBadmData as StockFromBadmData;
use Spot\Transformer\Stock\FromOptimaData as StockFromOptimaData;
use Spot\Transformer\Stock\FromVentaData as StockFromVentaData;
use Spot\Transformer\TransformerProvider;
use Spot\Transformer\TransformerStrategy;
use Spot\Transformer\Ttoptions\FromBadmData as TtoptionsFromBadmData;
use Spot\Transformer\Ttoptions\FromOptimaData as TtoptionsFromOptimaData;
use Spot\Transformer\Ttoptions\FromVentaData as TtoptionsFromVentaData;

class TransformerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        TransformerProvider::class,
        FromBadmData::class,
        FromOptimaData::class,
        FromVentaData::class,
        SkuFromBadmData::class,
        SkuFromOptimaData::class,
        SkuFromVentaData::class,
        StockFromBadmData::class,
        StockFromOptimaData::class,
        StockFromVentaData::class,
        TtoptionsFromBadmData::class,
        TtoptionsFromOptimaData::class,
        TtoptionsFromVentaData::class,
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
            ->add(TransformerProvider::class)
            ->addArgument($this->getContainer()->get(TransformerStrategy::TAG_NAME));
    }
}
