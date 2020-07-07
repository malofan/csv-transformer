<?php

declare(strict_types=1);

namespace Spot\Guesser;

interface PartnerReportType
{
    public function partner(): string;
    public function report(): string;
}
