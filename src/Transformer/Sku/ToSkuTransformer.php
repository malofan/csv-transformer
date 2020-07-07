<?php

declare(strict_types=1);

namespace Spot\Transformer\Sku;

use Spot\Transformer\FromSalesTransformer;

abstract class ToSkuTransformer extends FromSalesTransformer
{
    public const TYPE = 'sku';

    public function getType(): string
    {
        return self::TYPE;
    }
}
