<?php

declare(strict_types=1);

namespace Spot\Writer;

use League\Csv\Writer as LeagueWriter;
use League\Flysystem\FilesystemInterface;

abstract class Writer
{
    protected $filesystem;
    protected $stream;
    protected $writer;
    protected $targetDirectory;

    /**
     * @return string[]
     */
    abstract public function getHeader(): array;

    public function __construct(FilesystemInterface $filesystem, string $targetDirectory)
    {
        $this->filesystem = $filesystem;
        $this->stream = fopen('php://temp', 'rb+');
        $this->writer = LeagueWriter::createFromStream($this->stream);
        $this->writer->setDelimiter(';');
        $this->writer->insertOne($this->getHeader());
        $this->targetDirectory = rtrim($targetDirectory, '/') . '/';
    }

    abstract public function insertRecord($record): void; //phpcs:ignore

    public function save(string $fileName): void
    {
        $filePath = $this->targetDirectory . $fileName;

        if ($this->filesystem->has($filePath)) {
            $this->filesystem->delete($filePath);
        }
        $this->filesystem->writeStream($filePath, $this->stream);
    }
}
