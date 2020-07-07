<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

use Spot\PartnerTypes;

final class VentaFileMetaData extends BaseFileMetaData implements FileMetaDataStrategy
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

    public function supports(string $partnerType, string $reportType = null): bool
    {
        return PartnerTypes::VENTA === $partnerType;
    }
}
