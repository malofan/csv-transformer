<?php

declare(strict_types=1);

namespace Spot\DTO;

/**
 * @property-read string $distributorId
 * @property-read string $clientERPCode
 * @property-read string $clientName
 * @property-read string $clientAddress
 * @property-read string $okpo
 */
class TtoptionsRecord
{
    public $distributorId;
    public $clientERPCode;
    public $clientName;
    public $clientAddress;
    public $okpo;

    public function __construct(
        string $distributorId,
        string $clientERPCode,
        string $clientName,
        string $clientAddress,
        string $okpo
    ) {
        $this->distributorId = $distributorId;
        $this->clientERPCode = $clientERPCode;
        $this->clientName = $clientName;
        $this->clientAddress = $clientAddress;
        $this->okpo = $okpo;
    }
}
