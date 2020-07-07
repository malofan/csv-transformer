<?php

declare(strict_types=1);

namespace Spot\Guesser;

interface Choice extends PartnerReportType
{
    public const TAG_NAME = 'guesser.choice';
    /** @return string[] */
    public function headerFields(): array;
}
