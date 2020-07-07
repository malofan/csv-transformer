<?php

declare(strict_types=1);

namespace Spot\Container\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Spot\FileMetaData\Sales\BadmSales;
use Spot\FileMetaData\FileMetaData;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\FileMetaData\Sales\OptimaSales;
use Spot\FileMetaData\Stock\BadmStock;
use Spot\FileMetaData\Stock\OptimaStock;
use Spot\FileMetaData\Sales\VentaSales;
use Spot\FileMetaData\Stock\VentaStock;
use Spot\Guesser\Choice;
use Spot\Guesser\Guesser;
use Spot\Reader;

class FileMetaDataServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        BadmSales::class,
        BadmStock::class,
        VentaSales::class,
        VentaStock::class,
        OptimaSales::class,
        OptimaStock::class,
        FileMetaData::class,
        Guesser::class
    ];

    public function register(): void
    {
        $this->getContainer()
            ->add(BadmSales::class)->addTag(FileMetaDataStrategy::TAG_NAME_META_DATA)->addTag(Choice::TAG_NAME);
        $this->getContainer()
            ->add(BadmStock::class)->addTag(FileMetaDataStrategy::TAG_NAME_META_DATA)->addTag(Choice::TAG_NAME);
        $this->getContainer()
            ->add(VentaSales::class)->addTag(FileMetaDataStrategy::TAG_NAME_META_DATA)->addTag(Choice::TAG_NAME);
        $this->getContainer()
            ->add(VentaStock::class)->addTag(FileMetaDataStrategy::TAG_NAME_META_DATA)->addTag(Choice::TAG_NAME);
        $this->getContainer()
            ->add(OptimaSales::class)->addTag(FileMetaDataStrategy::TAG_NAME_META_DATA)->addTag(Choice::TAG_NAME);
        $this->getContainer()
            ->add(OptimaStock::class)->addTag(FileMetaDataStrategy::TAG_NAME_META_DATA)->addTag(Choice::TAG_NAME);

        $this->getContainer()
            ->add(FileMetaData::class)
            ->addArgument($this->getContainer()->get(FileMetaData::TAG_NAME));
        $this->getContainer()
            ->add(Guesser::class)
            ->addArgument($this->getContainer()->get(Choice::TAG_NAME))
            ->addArgument($this->getContainer()->get(Reader::class));
    }
}
