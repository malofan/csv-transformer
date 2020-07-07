<?php

declare(strict_types=1);

namespace Spot\Writer;

use Spot\DTO\TtoptionsRecord;
use Spot\Transformer\Ttoptions\ToTtoptionsTransformer;

class Ttoptions extends BaseWriter
{
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

    public static function supports(string $reportType): bool
    {
        return ToTtoptionsTransformer::TYPE === $reportType;
    }
}
