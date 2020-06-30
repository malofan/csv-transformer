<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use Spot\DTO\DeliveryRecord;

interface ToDeliveryDataTransformer
{
    public const TAG_NAME = 'delivery.data.transformer';

    /**
     * @param mixed[] $record
     */
    public function transform(array $record): DeliveryRecord;
}
