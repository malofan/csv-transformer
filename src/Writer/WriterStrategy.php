<?php

declare(strict_types=1);

namespace Spot\Writer;

interface WriterStrategy
{
    public static function supports(string $reportType): bool;
}
