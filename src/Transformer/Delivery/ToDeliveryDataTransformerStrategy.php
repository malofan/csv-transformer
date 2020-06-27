<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use Spot\DTO\DeliveryRecord;

interface ToDeliveryDataTransformerStrategy extends ToDeliveryDataTransformer
{
    public const TAG_NAME = 'delivery.data.transformer.strategy';
    public function supports(string $partnerType): bool;
}
