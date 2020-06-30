<?php

declare(strict_types=1);

namespace Spot\Container\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Spot\Transformer\Ttoptions\FromBadmSalesData;
use Spot\Transformer\Ttoptions\FromOptimaSalesData;
use Spot\Transformer\Ttoptions\FromVentaSalesData;
use Spot\Transformer\Ttoptions\TtoptionsTransformer;
use Spot\Transformer\Ttoptions\ToTtoptionsDataTransformer;

class TtoptionsTransformerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        FromBadmSalesData::class,
        FromOptimaSalesData::class,
        FromVentaSalesData::class,
        TtoptionsTransformer::class,
    ];

    public function register(): void
    {
        $this->getContainer()->add(FromBadmSalesData::class)->addTag(ToTtoptionsDataTransformer::TAG_NAME);
        $this->getContainer()->add(FromOptimaSalesData::class)->addTag(ToTtoptionsDataTransformer::TAG_NAME);
        $this->getContainer()->add(FromVentaSalesData::class)->addTag(ToTtoptionsDataTransformer::TAG_NAME);
        $this->getContainer()->add(TtoptionsTransformer::class)->addArgument(
            $this->getContainer()->get(ToTtoptionsDataTransformer::TAG_NAME)
        );
    }
}
