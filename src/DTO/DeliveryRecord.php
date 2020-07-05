<?php

declare(strict_types=1);

namespace Spot\DTO;

use DateTimeImmutable;

/**
 * @property-read int $distributorId
 * @property-read string $clientERPCode
 * @property-read DateTimeImmutable $date
 * @property-read string $distributorProductCode
 * @property-read float $qty
 * @property-read float|null $shipmentAmount
 * @property-read string|null $billNumber
 */
class DeliveryRecord
{
    public $distributorId;
    public $clientERPCode;
    public $date;
    public $distributorProductCode;
    public $qty;
    public $shipmentAmount;
    public $billNumber;

    public function __construct(
        int $distributorId,
        string $clientERPCode,
        ?DateTimeImmutable $date,
        string $distributorProductCode,
        float $qty,
        ?float $shipmentAmount,
        ?string $billNumber
    ) {
        $this->distributorId = $distributorId;
        $this->clientERPCode = $clientERPCode;
        $this->date = $date;
        $this->distributorProductCode = $distributorProductCode;
        $this->qty = $qty;
        $this->shipmentAmount = $shipmentAmount;
        $this->billNumber = $billNumber;
    }
}
