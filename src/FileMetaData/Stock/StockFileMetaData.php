<?php

declare(strict_types=1);

namespace Spot\FileMetaData\Stock;

use Spot\FileMetaData\BaseFileMetaData;
use Spot\FileMetaData\FileMetaDataStrategy;

abstract class StockFileMetaData extends BaseFileMetaData
{
    public function report(): string
    {
        return FileMetaDataStrategy::REPORT_TYPE_STOCK;
    }
}
