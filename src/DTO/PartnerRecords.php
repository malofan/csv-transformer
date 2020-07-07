<?php

declare(strict_types=1);

namespace Spot\DTO;

use Iterator;

/**
 * @property-read string $partnerType
 * @property-read string $reportType
 * @property-read Iterator $records
 */
class PartnerRecords
{
    public $partnerType;
    public $reportType;
    public $records;

    public function __construct(string $partnerType, string $reportType, Iterator $records)
    {
        $this->partnerType = $partnerType;
        $this->reportType = $reportType;
        $this->records = $records;
    }
}
