<?php

declare(strict_types=1);

namespace Spot\Writer;

use Spot\DTO\TtoptionsRecord;
use Spot\ExportReportTypes;
use Spot\PartnerTypes;

class Ttoptions extends BaseWriter
{
    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        $header = [
            'id дистрибьютора',
            'Код клиента ERP',
            'Название клиента',
            'Адрес клиента',
            'Название ТТ',
            'Адрес ТТ',
            'ОКПО'
        ];

        if ($this->withLegalAddress()) {
            $header[] = 'Юридический адрес клиента';
        }

        return $header;
    }

    /**
     * @param TtoptionsRecord $record phpcs:ignore
     */
    public function insertRecord($record): void // phpcs:ignore
    {
        $arrayRecord = [
            $record->distributorId,
            $record->clientERPCode,
            $record->clientName,
            $record->clientAddress,
            $record->clientName,
            $record->clientAddress,
            $record->okpo
        ];

        if ($this->withLegalAddress()) {
            $arrayRecord[] = $record->clientLegalAddress;
        }

        $this->writer->insertOne($arrayRecord);
    }

    public static function supports(string $reportType): bool
    {
        return ExportReportTypes::TTOPTIONS === $reportType;
    }

    private function withLegalAddress(): bool
    {
        return in_array($this->partnerType, [PartnerTypes::BADM, PartnerTypes::VENTA], true);
    }
}
