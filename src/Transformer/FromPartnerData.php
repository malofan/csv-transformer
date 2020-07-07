<?php

declare(strict_types=1);

namespace Spot\Transformer;

use Iterator;
use Spot\Exception\InvalidRecordException;
use Spot\Repository\DistributorRepository;

abstract class FromPartnerData implements Transformer
{
    protected $distributorRepository;

    public function __construct(DistributorRepository $distributorRepository)
    {
        $this->distributorRepository = $distributorRepository;
    }

    /**
     * @return string[]
     */
    abstract protected function getRequiredRecordFields(): array;

    /**
     * @param mixed[] $record
     */
    abstract protected function transformRecord(array $record); //phpcs:ignore

    abstract public function getPartnerType(): string;

    public function transformAll(Iterator $records): iterable //phpcs:ignore
    {
        foreach ($records as $record) {
            yield $this->transform($record);
        }
    }

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
