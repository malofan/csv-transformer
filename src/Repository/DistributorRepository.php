<?php

declare(strict_types=1);

namespace Spot\Repository;

use Spot\Exception\SpotException;

interface DistributorRepository
{
    /**
     * @throws SpotException
     */
    public function getIdBy(string $name, string $partnerType, ?string $reportType = null): int;
}
