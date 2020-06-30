<?php

declare(strict_types=1);

namespace Spot\Writer;

use Spot\DTO\TtoptionsRecord;

class Ttoptions extends Writer
{
    public const FILE_NAME = 'ttoptiopns.csv';

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return [
            'id дистрибьютора',
            'Код клиента ERP',
            'Название клиента',
            'Адрес клиента',
            'ОКПО'
        ];
    }

    /**
     * @param TtoptionsRecord $record phpcs:ignore
     */
    public function insertRecord($record): void // phpcs:ignore
    {
        $this->writer->insertOne(
            [
                $record->distributorId,
                $record->clientERPCode,
                $record->clientName,
                $record->clientAddress,
                $record->okpo
            ]
        );
    }
}
