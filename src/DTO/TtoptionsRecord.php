<?php

declare(strict_types=1);

namespace Spot\DTO;

/**
 * @property-read int $distributorId
 * @property-read string $clientERPCode
 * @property-read string $clientName
 * @property-read string $clientAddress
 * @property-read string $okpo
 * @property-read string|null $clientLegalAddress
 */
class TtoptionsRecord
{
    public $distributorId;
    public $clientERPCode;
    public $clientName;
    public $clientAddress;
    public $okpo;
    public $clientLegalAddress;

    public function __construct(
        int $distributorId,
        string $clientERPCode,
        string $clientName,
        string $clientAddress,
        string $okpo,
        ?string $clientLegalAddress = null
    ) {
        $this->distributorId = $distributorId;
        $this->clientERPCode = $clientERPCode;
        $this->clientName = $clientName;
        $this->clientAddress = $clientAddress;
        $this->okpo = $okpo;
        $this->clientLegalAddress = $clientLegalAddress;
    }
}
