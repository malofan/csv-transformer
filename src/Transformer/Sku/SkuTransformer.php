<?php

declare(strict_types=1);

namespace Spot\Transformer\Sku;

use Spot\Exception\SpotException;
use Spot\Transformer\BaseTransformer;

class SkuTransformer extends BaseTransformer
{
    /**
     * @throws SpotException
     */
    public function getFor(string $partnerType): ToSkuDataTransformer
    {
        return parent::getFor($partnerType);
    }
}
