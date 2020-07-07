<?php

declare(strict_types=1);

namespace Spot\FileMetaData\Sales;

use Spot\FileMetaData\BaseFileMetaData;
use Spot\FileMetaData\FileMetaDataStrategy;

abstract class SalesFileMetaData extends BaseFileMetaData
{
    public function report(): string
    {
        return FileMetaDataStrategy::REPORT_TYPE_SALES;
    }
}
