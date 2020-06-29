<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use Spot\DTO\DeliveryRecord;

interface ToDeliveryDataTransformer
{
    /**
     * @param mixed[] $record
     */
    public function transform(array $record): DeliveryRecord;
}
