<?php

declare(strict_types=1);

namespace Spot\Writer;

use League\Csv\Writer;
use League\Flysystem\FilesystemInterface;
use Spot\DTO\DeliveryRecord;

class Delivery
{
    private const DELIVERY_FILE_NAME = 'delivery.csv';

    private $filesystem;
    private $stream;
    private $writer;
    private $filePath;

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return [
            'id дистрибьютора',
            'Код клиента ERP',
            'Дата',
            'Код продукта дистрибьютора',
            'Количество',
            'Сумма отгрузки',
            'Номер расходной накладной'
        ];
    }

    public function __construct(FilesystemInterface $filesystem, string $targetDirectory)
    {
        $this->filesystem = $filesystem;
        $this->stream = fopen('php://temp', 'rb+');
        $this->writer = Writer::createFromStream($this->stream);
        $this->writer->setDelimiter(';');
        $this->writer->insertOne($this->getHeader());
        $this->filePath = rtrim($targetDirectory, '/') . '/' . self::DELIVERY_FILE_NAME;
    }

    /**
     * @param DeliveryRecord[] $records
     */
    public function insertRecords(iterable $records): void
    {
        foreach ($records as $record) {
            $this->insertRecord($record);
        }
    }

    public function insertRecord(DeliveryRecord $record): void
    {
        $this->writer->insertOne([
            $record->distributorId,
            $record->clientERPCode,
            ($record->date ? $record->date->format('Y.m.d') : null),
            $record->distributorProductCode,
            $record->qty,
            $record->shipmentAmount,
            $record->billNumber
        ]);
    }

    public function save(): void
    {
        if ($this->filesystem->has($this->filePath)) {
            $this->filesystem->delete($this->filePath);
        }
        $this->filesystem->writeStream($this->filePath, $this->stream);
    }
}
