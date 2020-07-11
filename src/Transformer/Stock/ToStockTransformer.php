<?php

declare(strict_types=1);

namespace Spot\Transformer\Stock;

use Spot\Transformer\FromStockTransformer;

abstract class ToStockTransformer extends FromStockTransformer
{
    public const TYPE = 'stocks';

    public function getType(): string
    {
        return self::TYPE;
    }
}
