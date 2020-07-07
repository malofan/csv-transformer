<?php

declare(strict_types=1);

namespace Spot\Writer;

use Spot\DTO\TransformedData;

interface Writer
{
    public function insertRecord($record): void; //phpcs:ignore
    public function getData(string $partnerType, string $reportType): TransformedData;
    public function insertRecords(iterable $records): void; //phpcs:ignore
}
