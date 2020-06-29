<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

interface FileMetaData
{
    public function delimiter(): string;
    public function headerOffset(): int;
}
