<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use Spot\Transformer\FromSalesTransformer;

abstract class ToDeliveryTransformer extends FromSalesTransformer
{
    public const TYPE = 'delivery';
    
    public function getType(): string
    {
        return self::TYPE;
    }
}
