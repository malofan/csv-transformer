<?php

declare(strict_types=1);

namespace Spot\FileMetaData\Stock;

use Spot\PartnerTypes;

final class BadmStock extends StockFileMetaData
{
    /**
     * @return string[]
     */
    public function headerFields(): array
    {
        return [
            'Производитель',
            'Поставщик',
            'Товар',
            'Код товара',
            'Единица измерения',
            'Количество реальное',
            'Количество в резерве',
            'Количество доступное',
            'Филиал',
            'Тип склада',
            'Серия товара',
            'Срок годности',
            'Код Мориона'
        ];
    }

    public function partner(): string
    {
        return PartnerTypes::BADM;
    }
}
