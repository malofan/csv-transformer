<?php

declare(strict_types=1);

namespace Spot\Transformer\Stock;

use Iterator;
use Spot\DTO\StockRecord;

interface ToStockDataTransformer
{
    public const TAG_NAME = 'stock.data.transformer.strategy';

    public function transformAll(Iterator $records): iterable;
}
