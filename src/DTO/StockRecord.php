<?php

declare(strict_types=1);

namespace Spot\DTO;

use DateTimeImmutable;

/**
 * @property-read int $distributorId
 * @property-read DateTimeImmutable $date
 * @property-read string $distributorProductCode
 * @property-read int $qty
 * @property-read string|null $batchNumber
 * @property-read DateTimeImmutable|null $bestBefore
 * @property-read DateTimeImmutable|null $manufactureDate
 */
class StockRecord
{
    public $distributorId;
    public $date;
    public $distributorProductCode;
    public $qty;
    public $batchNumber;
    public $bestBefore;
    public $manufactureDate;

    public function __construct(
        int $distributorId,
        DateTimeImmutable $date,
        string $distributorProductCode,
        int $qty,
        ?string $batchNumber,
        ?DateTimeImmutable $bestBefore,
        ?DateTimeImmutable $manufactureDate
    ) {
        $this->distributorId = $distributorId;
        $this->date = $date;
        $this->distributorProductCode = $distributorProductCode;
        $this->qty = $qty;
        $this->batchNumber = $batchNumber;
        $this->bestBefore = $bestBefore;
        $this->manufactureDate = $manufactureDate;
    }
}
