<?php

declare(strict_types=1);

namespace Spot\Container\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Spot\FileMetaData\BadmFileMetaData;
use Spot\FileMetaData\FileMetaData;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\FileMetaData\OptimaFileMetaData;
use Spot\FileMetaData\VentaFileMetaData;

class FileMetaDataServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        BadmFileMetaData::class,
        VentaFileMetaData::class,
        OptimaFileMetaData::class,
        FileMetaData::class,
    ];

    public function register(): void
    {
        $this->getContainer()->add(BadmFileMetaData::class)->addTag(FileMetaDataStrategy::TAG_NAME);
        $this->getContainer()->add(VentaFileMetaData::class)->addTag(FileMetaDataStrategy::TAG_NAME);
        $this->getContainer()->add(OptimaFileMetaData::class)->addTag(FileMetaDataStrategy::TAG_NAME);
        $this->getContainer()->add(FileMetaData::class)->addArgument(
            $this->getContainer()->get(FileMetaDataStrategy::TAG_NAME)
        );
    }
}
