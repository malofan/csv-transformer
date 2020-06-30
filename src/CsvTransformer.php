<?php

declare(strict_types=1);

namespace Spot;

use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Csv\Reader;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Spot\FileMetaData\FileMetaData;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\FileMetaData\BadmFileMetaData;
use Spot\FileMetaData\OptimaFileMetaData;
use Spot\FileMetaData\VentaFileMetaData;
use Spot\Transformer\Delivery\DeliveryTransformer;
use Spot\Transformer\Delivery\FromBadmSalesData as BadmDeliveryTransformer;
use Spot\Transformer\Delivery\FromOptimaSalesData as OptimaDeliveryTransformer;
use Spot\Transformer\Delivery\FromVentaSalesData as VentaDeliveryTransformer;
use Spot\Transformer\Delivery\ToDeliveryDataTransformer;
use Spot\Transformer\Ttoptions\FromBadmSalesData as BadmTtoptionsTransformer;
use Spot\Transformer\Ttoptions\FromOptimaSalesData as OptimaTtoptionsTransformer;
use Spot\Transformer\Ttoptions\FromVentaSalesData as VentaTtoptionsTransformer;
use Spot\Transformer\Ttoptions\ToTtoptionsDataTransformer;
use Spot\Transformer\Ttoptions\TtoptionsTransformer;
use Spot\Writer\Delivery;
use Spot\Writer\Ttoptions;

class CsvTransformer
{
    private const SKU_FILE_NAME = 'sku.csv';

    private $fileMetaData;
    private $deliveryTransformer;
    private $ttoptionsTransformer;
    private $deliveryWriter;
    private $ttoptionsWriter;

    public function __construct(
        FileMetaData $fileMetaData,
        DeliveryTransformer $deliveryTransformer,
        TtoptionsTransformer $ttoptionsTransformer,
        Delivery $deliveryWriter,
        Ttoptions $ttoptionsWriter
    ) {
        $this->fileMetaData = $fileMetaData;
        $this->deliveryTransformer = $deliveryTransformer;
        $this->ttoptionsTransformer = $ttoptionsTransformer;
        $this->deliveryWriter = $deliveryWriter;
        $this->ttoptionsWriter = $ttoptionsWriter;
    }

    /**
     *  $@param resource $stream
     */
    public function transformSalesData($stream, string $partnerType): void
    {
        $fileMetaData = $this->fileMetaData->getFor($partnerType);
        $reader = Reader::createFromStream($stream);
        $reader->setDelimiter($fileMetaData->delimiter());
        $reader->setHeaderOffset($fileMetaData->headerOffset());
        $this->checkForStreamFilter($reader);

        $deliveryTransformer = $this->deliveryTransformer->getFor($partnerType);
        $ttoptionsTransformer = $this->ttoptionsTransformer->getFor($partnerType);

        foreach ($reader->getRecords() as $record) {
            $this->deliveryWriter->insertRecord($deliveryTransformer->transform($record));
            $this->ttoptionsWriter->insertRecord($ttoptionsTransformer->transform($record));
        }

        $this->deliveryWriter->save($partnerType . '_' . Delivery::FILE_NAME);
        $this->ttoptionsWriter->save($partnerType . '_' . Ttoptions::FILE_NAME);
    }

    public static function create(string $targetDirectory, ?AdapterInterface $adapter = null): self
    {
        $container = new Container();
        $container->delegate(new ReflectionContainer());

        //region FileMetaDataStrategy
        $container->add(BadmFileMetaData::class)->addTag(FileMetaDataStrategy::TAG_NAME);
        $container->add(VentaFileMetaData::class)->addTag(FileMetaDataStrategy::TAG_NAME);
        $container->add(OptimaFileMetaData::class)->addTag(FileMetaDataStrategy::TAG_NAME);
        $container->add(FileMetaData::class)->addArgument($container->get(FileMetaDataStrategy::TAG_NAME));
        //endregion FileMetaDataStrategy

        //region ToDeliveryDataTransformer Strategy
        $container->add(BadmDeliveryTransformer::class)->addTag(ToDeliveryDataTransformer::TAG_NAME);
        $container->add(OptimaDeliveryTransformer::class)->addTag(ToDeliveryDataTransformer::TAG_NAME);
        $container->add(VentaDeliveryTransformer::class)->addTag(ToDeliveryDataTransformer::TAG_NAME);
        $container->add(DeliveryTransformer::class)->addArgument(
            $container->get(ToDeliveryDataTransformer::TAG_NAME)
        );
        //endregion ToDeliveryDataTransformer Strategy

        //region ToTtoptionsDataTransformer Strategy
        $container->add(BadmTtoptionsTransformer::class)->addTag(ToTtoptionsDataTransformer::TAG_NAME);
        $container->add(OptimaTtoptionsTransformer::class)->addTag(ToTtoptionsDataTransformer::TAG_NAME);
        $container->add(VentaTtoptionsTransformer::class)->addTag(ToTtoptionsDataTransformer::TAG_NAME);
        $container->add(TtoptionsTransformer::class)->addArgument(
            $container->get(ToTtoptionsDataTransformer::TAG_NAME)
        );
        //endregion ToTtoptionsDataTransformer Strategy

        $container->add(FilesystemInterface::class, self::getFilesystem($adapter));
        $container->add(Delivery::class)->addArguments([$container->get(FilesystemInterface::class), $targetDirectory]);
        $container->add(Ttoptions::class)->addArguments([$container->get(FilesystemInterface::class), $targetDirectory]);

        return new self(
            $container->get(FileMetaData::class),
            $container->get(DeliveryTransformer::class),
            $container->get(TtoptionsTransformer::class),
            $container->get(Delivery::class),
            $container->get(Ttoptions::class)
        );
    }

    private static function getFilesystem(?AdapterInterface $adapter): Filesystem
    {
        if (!$adapter) {
            $adapter = new Local('/');
        }

        return new Filesystem($adapter);
    }

    /**
     * @throws \League\Csv\Exception
     */
    private function checkForStreamFilter(Reader $reader): void
    {
        // This is ugly solution for windows-1251 encoded files found in stock
        $encodingList = [
            'UTF-8',
            'ASCII',
            'Windows-1251',
            'Windows-1252',
            'Windows-1254',
        ];
        $encoding = mb_detect_encoding($reader->getHeader()[0], $encodingList);

        if ($encoding !== 'UTF-8') {
            $reader->addStreamFilter(sprintf('convert.iconv.%s/UTF-8', $encoding));
        }
    }
}
