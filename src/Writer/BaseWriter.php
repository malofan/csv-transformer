<?php

declare(strict_types=1);

namespace Spot\Writer;

use League\Csv\Writer as LeagueWriter;
use Spot\DTO\StockRecord;
use Spot\DTO\TransformedData;

abstract class BaseWriter implements WriterStrategy, Writer
{
    protected $stream;
    protected $writer;

    /**
     * @return string[]
     */
    abstract protected function getHeader(): array;

    public function __construct()
    {
        $this->stream = fopen('php://temp', 'rb+');
        $this->writer = LeagueWriter::createFromStream($this->stream);
        $this->writer->setDelimiter(';');
        $this->writer->insertOne($this->getHeader());
    }

    abstract public function insertRecord($record): void; //phpcs:ignore

    public function getData(string $partnerType, string $reportType): TransformedData
    {
        return new TransformedData($partnerType, $reportType, $this->stream);
    }
    /**
     * @param StockRecord[] $records
     */
    public function insertRecords(iterable $records): void
    {
        foreach ($records as $record) {
            $this->insertRecord($record);
        }
    }
}
