<?php

declare(strict_types=1);

namespace Spot\DTO;

/**
 * @property-read string $partnerType
 * @property-read string $reportType
 * @property-read resource $stream
 */
class TransformedData
{
    public $partnerType;
    public $reportType;
    public $stream;

    public function __construct(string $partnerType, string $reportType, $stream) // phpcs:ignore
    {
        $this->partnerType = $partnerType;
        $this->reportType = $reportType;
        $this->stream = $stream;
    }
}
