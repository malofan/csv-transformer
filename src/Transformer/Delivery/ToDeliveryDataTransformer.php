<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use Spot\DTO\DeliveryRecord;

interface ToDeliveryDataTransformer
{
    /**
     * @param iterable $partnerRecords
     * @return DeliveryRecord[]
     */
    public function transformRecords(iterable $partnerRecords): iterable;

    /**
     * @param mixed[] $record
     */
    public function transformRecord(array $record): DeliveryRecord;
}
