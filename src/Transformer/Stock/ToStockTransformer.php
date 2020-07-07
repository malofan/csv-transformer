<?php

declare(strict_types=1);

namespace Spot\Transformer\Stock;

use Spot\Transformer\FromStockTransformer;

abstract class ToStockTransformer extends FromStockTransformer
{
    public const TYPE = 'stock';

    public function getType(): string
    {
        return self::TYPE;
    }
}
