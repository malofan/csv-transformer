<?php

declare(strict_types=1);

namespace Spot\Transformer;

use Spot\Exception\InvalidRecordException;

abstract class FromPartnerSalesData
{
    /**
     * @return string[]
     */
    abstract protected function getRequiredRecordFields(): array;

    /**
     * @param mixed[] $record
     */
    abstract protected function transformRecord(array $record); //phpcs:ignore

    /**
     * @param mixed[] $record
     * @throws InvalidRecordException
     */
    public function transform(array $record) //phpcs:ignore
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
