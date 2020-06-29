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
use Spot\Transformer\Delivery\FromBadmSalesData;
use Spot\Transformer\Delivery\ToDeliveryDataTransformer;
use Spot\Transformer\Delivery\ToDeliveryDataTransformerStrategy;
use Spot\Writer\Delivery;

class CsvTransformer
{
    private const TTOPTIONS_FILE_NAME = 'ttoptiopns.csv';
    private const SKU_FILE_NAME = 'sku.csv';

    private $fileMetaDataSet;
    private $deliveryTransformers;
    private $deliveryWriter;

    /**
     * @param FileMetaDataStrategy[] $fileMetaDataSet
     * @param ToDeliveryDataTransformerStrategy[] $deliveryTransformers
     */
    private function __construct(iterable $fileMetaDataSet, iterable $deliveryTransformers, Delivery $deliveryWriter)
    {
        $this->fileMetaDataSet = $fileMetaDataSet;
        $this->deliveryTransformers = $deliveryTransformers;
        $this->deliveryWriter = $deliveryWriter;
    }

    /**
     *  $@param resource $stream
     */
    public function transformSalesData($stream, string $partnerType): void
    {
        $fileMetaData = $this->getFileMetaDataFor($partnerType);
        $reader = Reader::createFromStream($stream);
        $reader->addStreamFilter('convert.iconv.windows-1251/UTF-8');
        $reader->setDelimiter($fileMetaData->delimiter());
        $reader->setHeaderOffset($fileMetaData->headerOffset());

        $deliveryTransformer = new FromBadmSalesData();

        foreach ($reader->getRecords() as $record) {
            $this->deliveryWriter->insertRecord($deliveryTransformer->transformRecord($record));
        }

        $this->deliveryWriter->save();
    }

    public static function create(string $targetDirectory, ?AdapterInterface $adapter = null): self
    {
        $container = new Container();
        $container->delegate(new ReflectionContainer());

        //region FileMetaDataStrategy
        $container->add(BadmFileMetaData::class)->addTag(FileMetaDataStrategy::TAG_NAME);
        //endregion FileMetaDataStrategy

        //region ToDeliveryDataTransformerStrategy
        $container->add(FromBadmSalesData::class)->addTag(ToDeliveryDataTransformerStrategy::TAG_NAME);
        //endregion ToDeliveryDataTransformerStrategy

        $container->add(FilesystemInterface::class, self::getFilesystem($adapter));
        $container->add(Delivery::class)->addArguments([$container->get(FilesystemInterface::class), $targetDirectory]);

        return new self(
            $container->get(FileMetaDataStrategy::TAG_NAME),
            $container->get(ToDeliveryDataTransformerStrategy::TAG_NAME),
            $container->get(Delivery::class)
        );
    }

    private static function getFilesystem(?AdapterInterface $adapter): Filesystem
    {
        if (!$adapter) {
            $adapter = new Local('/');
        }

        return new Filesystem($adapter);
    }

    private function getFileMetaDataFor(string $partnerType): FileMetaData
    {
        foreach ($this->fileMetaDataSet as $fileMetaData) {
            if ($fileMetaData->supports($partnerType)) {

                return $fileMetaData;
            }
        }

        throw new \LogicException(sprintf('FileMetaData for partner type "%s" doesn\'t exists', $partnerType));
    }

    private function getDeliveryTransformerFor(string $partnerType): ToDeliveryDataTransformer
    {
        foreach ($this->deliveryTransformers as $transformer) {
            if ($transformer->supports($partnerType)) {

                return $transformer;
            }
        }

        throw new \LogicException(sprintf('DeliveryDataTransformer for partner type "%s" doesn\'t exists', $partnerType));
    }
}
