<?php

declare(strict_types=1);

namespace Spot\Transformer\Stock;

use Spot\Exception\SpotException;
use Spot\Transformer\BaseTransformer;

class StockTransformer extends BaseTransformer
{
    /**
     * @throws SpotException
     */
    public function getFor(string $partnerType): ToStockDataTransformer
    {
        return parent::getFor($partnerType);
    }
}
