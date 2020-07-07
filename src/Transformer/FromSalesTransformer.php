<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use Spot\Exception\SpotException;
use Spot\Transformer\BaseTransformer;

class DeliveryTransformer extends BaseTransformer
{
    /**
     * @throws SpotException
     */
    public function getFor(string $partnerType): ToDeliveryDataTransformer
    {
        return parent::getFor($partnerType);
    }
}
