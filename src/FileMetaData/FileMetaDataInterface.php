<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

interface FileMetaDataInterface
{
    public function delimiter(): string;
    public function headerOffset(): int;
}
