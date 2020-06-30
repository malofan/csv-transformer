<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

use Spot\PartnerTypes;

final class OptimaFileMetaData extends BaseFileMetaDataInterface implements FileMetaDataStrategy
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

    public function supports(string $partnerType): bool
    {
        return PartnerTypes::OPTIMA === $partnerType;
    }
}
