<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

use Spot\PartnerTypes;

final class VentaFileMetaData extends BaseFileMetaData implements FileMetaDataStrategy
{
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

    public function supports(string $partnerType): bool
    {
        return PartnerTypes::VENTA === $partnerType;
    }
}
