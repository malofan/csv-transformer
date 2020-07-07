<?php

declare(strict_types=1);

namespace Spot;

use Iterator;
use League\Csv\Reader as LeagueReader;
use Spot\FileMetaData\FileMetaDataInterface;

class Reader
{
    private $reader;

    /**
     * @param resource $stream phpcs:ignore
     * @throws Exception\SpotException
     * @throws \League\Csv\Exception
     */
    public function read($stream, FileMetaDataInterface $fileMetaData): self //phpcs:ignore
    {
        $this->reader = LeagueReader::createFromStream($stream);
        $this->reader->setDelimiter($fileMetaData->delimiter());
        $this->reader->setHeaderOffset($fileMetaData->headerOffset());
        $this->checkForStreamFilter();

        return $this;
    }

    public function getRecords(): Iterator
    {
        return $this->reader->getRecords();
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->reader->getHeader() ?: $this->reader->fetchOne();
    }

    /**
     * @throws \League\Csv\Exception
     */
    private function checkForStreamFilter(): void
    {
        // This is ugly solution for windows-1251 encoded files found in stock
        $encodingList = [
            'UTF-8',
            'ASCII',
            'Windows-1251',
            'Windows-1252',
            'Windows-1254',
        ];
        $encoding = mb_detect_encoding($this->getHeader()[0], $encodingList);

        if ($encoding !== 'UTF-8') {
            $this->reader->addStreamFilter(sprintf('convert.iconv.%s/UTF-8', $encoding));
        }
    }
}
