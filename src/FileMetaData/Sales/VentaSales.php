<?php

declare(strict_types=1);

namespace Spot\FileMetaData\Sales;

use Spot\PartnerTypes;

final class VentaSales extends SalesFileMetaData
{
    /**
     * @return string[]
     */
    public function headerFields(): array
    {
        return [
            'Клиент',
            'Город',
            'ОКПО',
            'Адрес',
            'Область',
            'Склад',
            'Код товара',
            'Товар',
            'Адрес дост.',
            'Дата накладной',
            'Количество',
            'Код Морион',
            'UID пункта доставки'
        ];
    }

    public function partner(): string
    {
        return PartnerTypes::VENTA;
    }
}
