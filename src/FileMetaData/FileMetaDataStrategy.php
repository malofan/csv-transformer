<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

interface FileMetaDataStrategy extends FileMetaDataInterface
{
    public const REPORT_TYPE_SALES = 'sales';
    public const REPORT_TYPE_STOCK = 'stock';
    public const TAG_NAME = 'file.meta.data.strategy';
    public function supports(string $partnerType, string $reportType = null): bool;
    /** @return string[] */
    public function headerFields(): array;
}
