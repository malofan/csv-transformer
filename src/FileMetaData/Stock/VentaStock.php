<?php

declare(strict_types=1);

namespace Spot\FileMetaData\Stock;

use Spot\PartnerTypes;

final class VentaStock extends StockFileMetaData
{
    /**
     * @return string[]
     */
    public function headerFields(): array
    {
        return ['Наименование Препарата', 'Код Мориона', 'Общий остаток'];
    }

    public function partner(): string
    {
        return PartnerTypes::VENTA;
    }
}
