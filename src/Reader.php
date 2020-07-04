<?php

declare(strict_types=1);

namespace Spot;

use Iterator;
use League\Csv\Reader as LeagueReader;
use Spot\FileMetaData\FileMetaData;
use Spot\FileMetaData\FileMetaDataInterface;

class Reader
{
    private $fileMetaData;

    public function __construct(FileMetaData $fileMetaData)
    {
        $this->fileMetaData = $fileMetaData;
    }

    /**
     * @param resource $stream
     * @throws Exception\SpotException
     * @throws \League\Csv\Exception
     */
    public function read($stream, FileMetaDataInterface $fileMetaData): Iterator
    {
        $reader = LeagueReader::createFromStream($stream);
        $reader->setDelimiter($fileMetaData->delimiter());
        $reader->setHeaderOffset($fileMetaData->headerOffset());
        $this->checkForStreamFilter($reader);

        return $reader->getRecords();
    }

    /**
     * @throws \League\Csv\Exception
     */
    private function checkForStreamFilter(LeagueReader $reader): void
    {
        // This is ugly solution for windows-1251 encoded files found in stock
        $encodingList = [
            'UTF-8',
            'ASCII',
            'Windows-1251',
            'Windows-1252',
            'Windows-1254',
        ];
        $header = $reader->getHeader() ?: $reader->fetchOne();
        $encoding = mb_detect_encoding($header[0], $encodingList);

        if ($encoding !== 'UTF-8') {
            $reader->addStreamFilter(sprintf('convert.iconv.%s/UTF-8', $encoding));
        }
    }
}
