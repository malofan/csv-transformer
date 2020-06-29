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
use Spot\Transformer\Delivery\FromBadmSalesData;
use Spot\Transformer\Delivery\FromOptimaSalesData;
use Spot\Transformer\Delivery\FromVentaSalesData;
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
        $reader->setDelimiter($fileMetaData->delimiter());
        $reader->setHeaderOffset($fileMetaData->headerOffset());
        $this->checkForStreamFilter($reader);

//        var_dump($reader->getHeader());
//        foreach ($reader->getRecords() as $record) {
//            var_dump($record);
//            return;
//        }

        $deliveryTransformer = $this->getDeliveryTransformerFor($partnerType);

        foreach ($reader->getRecords() as $record) {
            $this->deliveryWriter->insertRecord($deliveryTransformer->transform($record));
        }

        $this->deliveryWriter->save();
    }

    public static function create(string $targetDirectory, ?AdapterInterface $adapter = null): self
    {
        $container = new Container();
        $container->delegate(new ReflectionContainer());

        //region FileMetaDataStrategy
        $container->add(BadmFileMetaData::class)->addTag(FileMetaDataStrategy::TAG_NAME);
        $container->add(VentaFileMetaData::class)->addTag(FileMetaDataStrategy::TAG_NAME);
        $container->add(OptimaFileMetaData::class)->addTag(FileMetaDataStrategy::TAG_NAME);
        //endregion FileMetaDataStrategy

        //region ToDeliveryDataTransformerStrategy
        $container->add(FromBadmSalesData::class)->addTag(ToDeliveryDataTransformerStrategy::TAG_NAME);
        $container->add(FromVentaSalesData::class)->addTag(ToDeliveryDataTransformerStrategy::TAG_NAME);
        $container->add(FromOptimaSalesData::class)->addTag(ToDeliveryDataTransformerStrategy::TAG_NAME);
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
