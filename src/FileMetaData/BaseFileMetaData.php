<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

abstract class BaseFileMetaDataInterface implements FileMetaDataInterface
{
    public function delimiter(): string
    {
        return ';';
    }

    public function headerOffset(): ?int
    {
        return 0;
    }
}
