<?php

declare(strict_types=1);

namespace Spot\Transformer\Delivery;

use Spot\DTO\DeliveryRecord;
use Spot\Exception\InvalidRecordException;

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

    /**
     * @param mixed[] $record
     * @throws InvalidRecordException
     */
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
            if (!array_key_exists($field, $record)) {
                throw InvalidRecordException::notProvidedField($field);
            }
        }
    }
}
