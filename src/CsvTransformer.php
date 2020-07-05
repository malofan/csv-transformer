<?php

declare(strict_types=1);

namespace Spot;

use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Spot\Container\ServiceProvider\DeliveryTransformerServiceProvider;
use Spot\Container\ServiceProvider\FileMetaDataServiceProvider;
use Spot\Container\ServiceProvider\SkuTransformerServiceProvider;
use Spot\Container\ServiceProvider\StockTransformerServiceProvider;
use Spot\Container\ServiceProvider\TtoptionsTransformerServiceProvider;
use Spot\FileMetaData\FileMetaData;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\Repository\DistributorRepository;
use Spot\Repository\JsonDistributorRepository;
use Spot\Transformer\Delivery\DeliveryTransformer;
use Spot\Transformer\Sku\SkuTransformer;
use Spot\Transformer\Stock\StockTransformer;
use Spot\Transformer\Ttoptions\TtoptionsTransformer;
use Spot\Writer\Delivery;
use Spot\Writer\Sku;
use Spot\Writer\Stock;
use Spot\Writer\Ttoptions;

class CsvTransformer
{
    private $reader;
    private $fileMetaData;
    private $deliveryTransformerProvider;
    private $ttoptionsTransformerProvider;
    private $skuTransformerProvider;
    private $stockTransformer;
    private $deliveryWriter;
    private $ttoptionsWriter;
    private $skuWriter;
    private $stockWriter;

    public function __construct(
        Reader $reader,
        FileMetaData $fileMetaData,
        DeliveryTransformer $deliveryTransformer,
        TtoptionsTransformer $ttoptionsTransformer,
        SkuTransformer $skuTransformer,
        StockTransformer $stockTransformer,
        Delivery $deliveryWriter,
        Ttoptions $ttoptionsWriter,
        Sku $skuWriter,
        Stock $stockWriter
    ) {
        $this->reader = $reader;
        $this->fileMetaData = $fileMetaData;
        $this->deliveryTransformerProvider = $deliveryTransformer;
        $this->ttoptionsTransformerProvider = $ttoptionsTransformer;
        $this->skuTransformerProvider = $skuTransformer;
        $this->stockTransformer = $stockTransformer;
        $this->deliveryWriter = $deliveryWriter;
        $this->ttoptionsWriter = $ttoptionsWriter;
        $this->skuWriter = $skuWriter;
        $this->stockWriter = $stockWriter;
    }

    /**
     *  $@param resource $stream
     */
    public function transformSalesData($stream, string $partnerType): void // phpcs:ignore
    {
        $fileMetaData = $this->fileMetaData->getFor($partnerType, FileMetaDataStrategy::REPORT_TYPE_SALES);
        $deliveryTransformer = $this->deliveryTransformerProvider->getFor($partnerType);
        $ttoptionsTransformer = $this->ttoptionsTransformerProvider->getFor($partnerType);
        $skuTransformer = $this->skuTransformerProvider->getFor($partnerType);

        foreach ($this->reader->read($stream, $fileMetaData) as $record) {
            $this->deliveryWriter->insertRecord($deliveryTransformer->transform($record));
            $this->ttoptionsWriter->insertRecord($ttoptionsTransformer->transform($record));
            $this->skuWriter->insertRecord($skuTransformer->transform($record));
        }

        $this->deliveryWriter->save($partnerType . '_' . Delivery::FILE_NAME);
        $this->ttoptionsWriter->save($partnerType . '_' . Ttoptions::FILE_NAME);
        $this->skuWriter->save($partnerType . '_' . Sku::FILE_NAME);
    }

    /**
     *  $@param resource $stream
     */
    public function transformStockData($stream, string $partnerType): void // phpcs:ignore
    {
        $this->stockWriter->insertRecords(
            $this->stockTransformer->getFor($partnerType)->transformAll(
                $this->reader->read(
                    $stream,
                    $this->fileMetaData->getFor($partnerType, FileMetaDataStrategy::REPORT_TYPE_STOCK)
                )
            )
        );

        $this->stockWriter->save($partnerType . '_' . Stock::FILE_NAME);
    }

    public static function create(string $targetDirectory, ?AdapterInterface $adapter = null): self
    {
        $container = new Container();
        $container->delegate((new ReflectionContainer())->cacheResolutions());

        $container->addServiceProvider(FileMetaDataServiceProvider::class);
        $container->addServiceProvider(DeliveryTransformerServiceProvider::class);
        $container->addServiceProvider(TtoptionsTransformerServiceProvider::class);
        $container->addServiceProvider(SkuTransformerServiceProvider::class);
        $container->addServiceProvider(StockTransformerServiceProvider::class);

        $container->add(FilesystemInterface::class, self::getFilesystem($adapter));
        $container->add(Delivery::class)->addArguments([$container->get(FilesystemInterface::class), $targetDirectory]);
        $container->add(Ttoptions::class)->addArguments(
            [$container->get(FilesystemInterface::class), $targetDirectory]
        );
        $container->add(Sku::class)->addArguments([$container->get(FilesystemInterface::class), $targetDirectory]);
        $container->add(Stock::class)->addArguments([$container->get(FilesystemInterface::class), $targetDirectory]);
        $container->add(Reader::class)->addArgument(FileMetaData::class);

        $container->add(
            DistributorRepository::class,
            new JsonDistributorRepository(file_get_contents(__DIR__ . '/../distributorMap.json'))
        );

        return new self(
            $container->get(Reader::class),
            $container->get(FileMetaData::class),
            $container->get(DeliveryTransformer::class),
            $container->get(TtoptionsTransformer::class),
            $container->get(SkuTransformer::class),
            $container->get(StockTransformer::class),
            $container->get(Delivery::class),
            $container->get(Ttoptions::class),
            $container->get(Sku::class),
            $container->get(Stock::class)
        );
    }

    private static function getFilesystem(?AdapterInterface $adapter): Filesystem
    {
        if (!$adapter) {
            $adapter = new Local('/');
        }

        return new Filesystem($adapter);
    }
}
