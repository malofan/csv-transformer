<?php

declare(strict_types=1);

namespace Spot\FileMetaData\Sales;

use Spot\PartnerTypes;

final class OptimaSales extends SalesFileMetaData
{
    /**
     * @return string[]
     */
    public function headerFields(): array
    {
        return [
            'Товар',
            'Код товара',
            'Код поставщика',
            'Дебитор',
            'ОКПО',
            'Вид деятельности',
            'Дебитор доставки',
            'Фактический адрес',
            'Город',
            'Область',
            'Филиал',
            'День',
            'Продажи шт'
        ];
    }

    public function partner(): string
    {
        return PartnerTypes::OPTIMA;
    }
}
