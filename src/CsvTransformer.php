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
use Spot\Container\ServiceProvider\DeliveryTransformerServiceProvider;
use Spot\Container\ServiceProvider\FileMetaDataServiceProvider;
use Spot\Container\ServiceProvider\SkuTransformerServiceProvider;
use Spot\Container\ServiceProvider\TtoptionsTransformerServiceProvider;
use Spot\FileMetaData\FileMetaData;
use Spot\Transformer\Delivery\DeliveryTransformer;
use Spot\Transformer\Sku\SkuTransformer;
use Spot\Transformer\Ttoptions\TtoptionsTransformer;
use Spot\Writer\Delivery;
use Spot\Writer\Sku;
use Spot\Writer\Ttoptions;

class CsvTransformer
{
    private $fileMetaData;
    private $deliveryTransformerProvider;
    private $ttoptionsTransformerProvider;
    private $deliveryWriter;
    private $ttoptionsWriter;
    private $skuTransformerProvider;

    public function __construct(
        FileMetaData $fileMetaData,
        DeliveryTransformer $deliveryTransformer,
        TtoptionsTransformer $ttoptionsTransformer,
        SkuTransformer $skuTransformer,
        Delivery $deliveryWriter,
        Ttoptions $ttoptionsWriter,
        Sku $skuWriter
    ) {
        $this->fileMetaData = $fileMetaData;
        $this->deliveryTransformerProvider = $deliveryTransformer;
        $this->ttoptionsTransformerProvider = $ttoptionsTransformer;
        $this->skuTransformerProvider = $skuTransformer;
        $this->deliveryWriter = $deliveryWriter;
        $this->ttoptionsWriter = $ttoptionsWriter;
        $this->skuWriter = $skuWriter;
    }

    /**
     *  $@param resource $stream
     */
    public function transformSalesData($stream, string $partnerType): void // phpcs:ignore
    {
        $fileMetaData = $this->fileMetaData->getFor($partnerType);
        $reader = Reader::createFromStream($stream);
        $reader->setDelimiter($fileMetaData->delimiter());
        $reader->setHeaderOffset($fileMetaData->headerOffset());
        $this->checkForStreamFilter($reader);

        $deliveryTransformer = $this->deliveryTransformerProvider->getFor($partnerType);
        $ttoptionsTransformer = $this->ttoptionsTransformerProvider->getFor($partnerType);
        $skuTransformer = $this->skuTransformerProvider->getFor($partnerType);

        foreach ($reader->getRecords() as $record) {
            $this->deliveryWriter->insertRecord($deliveryTransformer->transform($record));
            $this->ttoptionsWriter->insertRecord($ttoptionsTransformer->transform($record));
            $this->skuWriter->insertRecord($skuTransformer->transform($record));
        }

        $this->deliveryWriter->save($partnerType . '_' . Delivery::FILE_NAME);
        $this->ttoptionsWriter->save($partnerType . '_' . Ttoptions::FILE_NAME);
        $this->skuWriter->save($partnerType . '_' . Sku::FILE_NAME);
    }

    public static function create(string $targetDirectory, ?AdapterInterface $adapter = null): self
    {
        $container = new Container();
        $container->delegate(new ReflectionContainer());

        $container->addServiceProvider(FileMetaDataServiceProvider::class);
        $container->addServiceProvider(DeliveryTransformerServiceProvider::class);
        $container->addServiceProvider(TtoptionsTransformerServiceProvider::class);
        $container->addServiceProvider(SkuTransformerServiceProvider::class);

        $container->add(FilesystemInterface::class, self::getFilesystem($adapter));
        $container->add(Delivery::class)->addArguments([$container->get(FilesystemInterface::class), $targetDirectory]);
        $container->add(Ttoptions::class)->addArguments(
            [$container->get(FilesystemInterface::class), $targetDirectory]
        );
        $container->add(Sku::class)->addArguments([$container->get(FilesystemInterface::class), $targetDirectory]);

        return new self(
            $container->get(FileMetaData::class),
            $container->get(DeliveryTransformer::class),
            $container->get(TtoptionsTransformer::class),
            $container->get(SkuTransformer::class),
            $container->get(Delivery::class),
            $container->get(Ttoptions::class),
            $container->get(Sku::class)
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
