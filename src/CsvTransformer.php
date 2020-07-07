<?php

declare(strict_types=1);

namespace Spot;

use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Spot\Container\ServiceProvider\TransformerServiceProvider;
use Spot\Container\ServiceProvider\FileMetaDataServiceProvider;
use Spot\DTO\TransformedData;
use Spot\FileMetaData\FileMetaData;
use Spot\FileMetaData\FileMetaDataStrategy;
use Spot\Guesser\Guesser;
use Spot\Repository\DistributorRepository;
use Spot\Repository\JsonDistributorRepository;
use Spot\Transformer\TransformerProvider;
use Spot\Writer\WriterFactory;

class CsvTransformer
{
    private $reader;
    private $fileMetaData;
    private $transformers;
    private $stockTransformer;
    private $writerFactory;
    private $guesser;

    public function __construct(
        Reader $reader,
        FileMetaData $fileMetaData,
        TransformerProvider $transformerProvider,
        WriterFactory $writerFactory,
        Guesser $guesser
    ) {
        $this->reader = $reader;
        $this->fileMetaData = $fileMetaData;
        $this->transformers = $transformerProvider;
        $this->writerFactory = $writerFactory;
        $this->guesser = $guesser;
    }

    /**
     * @param resource $stream phpcs:ignore
     * @return TransformedData[]
     */
    public function transform($stream): iterable // phpcs:ignore
    {
        $data = $this->guesser->guessBy($stream);

        foreach ($this->transformers->getFor($data->partnerType, $data->reportType) as $transformer) {
            $writer = $this->writerFactory->getFor($transformer->getType());
            $writer->insertRecords($transformer->transformAll($data->records));

            yield $writer->getData($data->partnerType, $transformer->getType());
        }
    }

    /**
     * @param resource $stream phpcs:ignore
     * @return TransformedData[]
     */
    public function transformSalesData($stream, string $partnerType): iterable // phpcs:ignore
    {
        $fileMetaData = $this->fileMetaData->getFor($partnerType, FileMetaDataStrategy::REPORT_TYPE_SALES);
        $records = $this->reader->read($stream, $fileMetaData)->getRecords();

        foreach ($this->transformers->getFor($partnerType, FileMetaDataStrategy::REPORT_TYPE_SALES) as $transformer) {
            $writer = $this->writerFactory->getFor($transformer->getType());
            $writer->insertRecords($transformer->transformAll($records));

            yield $writer->getData($partnerType, FileMetaDataStrategy::REPORT_TYPE_SALES);
        }
    }

    /**
     *  $@param resource $stream phpcs:ignore
     */
    public function transformStockData($stream, string $partnerType): TransformedData // phpcs:ignore
    {
        $writer = $this->writerFactory->getFor(FileMetaDataStrategy::REPORT_TYPE_STOCK);
        $fileMetaData = $this->fileMetaData->getFor($partnerType, FileMetaDataStrategy::REPORT_TYPE_STOCK);

        $writer->insertRecords(
            $this->stockTransformer->getFor($partnerType)->transformAll(
                $this->reader->read($stream, $fileMetaData)->getRecords()
            )
        );

        return $writer->getData($partnerType, FileMetaDataStrategy::REPORT_TYPE_STOCK);
    }

    public static function create(?AdapterInterface $adapter = null): self
    {
        $container = new Container();
        $container->delegate((new ReflectionContainer())->cacheResolutions());

        $container->addServiceProvider(FileMetaDataServiceProvider::class);
        $container->addServiceProvider(TransformerServiceProvider::class);

        $container->add(FilesystemInterface::class, self::getFilesystem($adapter));

        $container->add(
            DistributorRepository::class,
            new JsonDistributorRepository(file_get_contents(__DIR__ . '/../distributorMap.json'))
        );

        return new self(
            $container->get(Reader::class),
            $container->get(FileMetaData::class),
            $container->get(TransformerProvider::class),
            $container->get(WriterFactory::class),
            $container->get(Guesser::class)
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
