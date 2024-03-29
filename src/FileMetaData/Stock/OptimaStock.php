<?php

declare(strict_types=1);

namespace Spot\FileMetaData\Stock;

use Spot\PartnerTypes;

final class OptimaStock extends StockFileMetaData
{
    /**
     * @return string[]
     */
    public function headerFields(): array
    {
        return ['Товар', 'Код товара', 'Все'];
    }

    public function headerOffset(): ?int
    {
        return null;
    }

    public function partner(): string
    {
        return PartnerTypes::OPTIMA;
    }
}
