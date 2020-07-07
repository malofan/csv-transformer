<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

use Spot\Guesser\Choice;

abstract class BaseFileMetaData implements FileMetaDataStrategy, Choice
{
    public function delimiter(): string
    {
        return ';';
    }

    public function headerOffset(): ?int
    {
        return 0;
    }

    public function supports(string $partnerType, string $reportType): bool
    {
        return $this->partner() === $partnerType && $this->report() === $reportType;
    }
}
