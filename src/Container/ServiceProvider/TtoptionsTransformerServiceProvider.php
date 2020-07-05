<?php

declare(strict_types=1);

namespace Spot\Container\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\Ttoptions\FromBadmData;
use Spot\Transformer\Ttoptions\FromOptimaData;
use Spot\Transformer\Ttoptions\FromVentaData;
use Spot\Transformer\Ttoptions\TtoptionsTransformer;
use Spot\Transformer\Ttoptions\ToTtoptionsDataTransformer;

class TtoptionsTransformerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        FromBadmData::class,
        FromOptimaData::class,
        FromVentaData::class,
        TtoptionsTransformer::class,
    ];

    public function register(): void
    {
        $this->getContainer()
            ->add(FromBadmData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(ToTtoptionsDataTransformer::TAG_NAME);
        $this->getContainer()
            ->add(FromOptimaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(ToTtoptionsDataTransformer::TAG_NAME);
        $this->getContainer()
            ->add(FromVentaData::class)
            ->addArgument(DistributorRepository::class)
            ->addTag(ToTtoptionsDataTransformer::TAG_NAME);
        $this->getContainer()->add(TtoptionsTransformer::class)->addArgument(
            $this->getContainer()->get(ToTtoptionsDataTransformer::TAG_NAME)
        );
    }
}
