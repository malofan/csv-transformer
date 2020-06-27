<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

interface FileMetaDataStrategy extends FileMetaData
{
    public const TAG_NAME = 'file.meta.data.strategy';
    public function supports(string $partnerType): bool;
}
