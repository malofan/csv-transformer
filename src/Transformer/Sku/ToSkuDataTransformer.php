<?php

declare(strict_types=1);

namespace Spot\Transformer\Sku;

use Spot\DTO\SkuRecord;

interface ToSkuDataTransformer
{
    public const TAG_NAME = 'sku.data.transformer.strategy';

    /**
     * @param mixed[] $record
     */
    public function transform(array $record): SkuRecord;
}
