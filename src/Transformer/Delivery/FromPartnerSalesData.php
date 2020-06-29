<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use DateTimeImmutable;
use LogicException;
use Spot\DTO\DeliveryRecord;
use Spot\PartnerTypes;

abstract class FromPartnerSalesData implements ToDeliveryDataTransformer
{
    /**
     * @return string[]
     */
    abstract protected function getRequiredRecordFields(): array;

    /**
     * @param mixed[] $record
     */
    abstract protected function transformRecord(array $record): DeliveryRecord;

    public function transform(array $record): DeliveryRecord
    {
        $this->assertValidRecord($record);

        return $this->transformRecord($record);
    }

    /**
     * @param mixed[] $record
     */
    private function assertValidRecord(array $record): void
    {
        foreach ($this->getRequiredRecordFields() as $field) {
            if (array_key_exists($field, $record)) {
                new LogicException(sprintf('Field "%s" was not provided in record', $field));
            }
        }
    }
}
