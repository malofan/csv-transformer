<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

abstract class BaseFileMetaData implements FileMetaData
{
    public function delimiter(): string
    {
        return ';';
    }

    public function headerOffset(): int
    {
        return 0;
    }
}
