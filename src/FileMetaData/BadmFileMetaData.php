<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

use Spot\PartnerTypes;

final class BadmFileMetaData extends BaseFileMetaDataInterface implements FileMetaDataStrategy
{
    /**
     * @return string[]
     */
    public function headerFields(): array
    {
        return [
            'Фирма',
            'Область',
            'Город',
            'Дата накл',
            'Факт.адрес доставки',
            'Юр. адрес клиента',
            'Клиент',
            'Код клиента',
            'Код подразд кл',
            'ОКПО клиента',
            'Лицензия',
            'Дата окончания лицензии',
            'Код товара',
            'Штрих-код товара',
            'Товар',
            'Код мориона',
            'ЕИ',
            'Производитель',
            'Поставщик',
            'Количество',
            'Склад/филиал'
        ];
    }

    public function supports(string $partnerType, string $reportType = null): bool
    {
        return PartnerTypes::BADM === $partnerType;
    }
}
