<?php

declare(strict_types=1);

namespace Spot\Command;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Plugin\ListFiles;
use Spot\CsvTransformer;
use Spot\Exception\SpotException;
use Spot\Transformer\Sku\ToSkuTransformer;
use Spot\Transformer\Ttoptions\ToTtoptionsTransformer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TransformCommand extends Command
{
    protected static $defaultName = 'spot:transform';

    private $lineHashes = [];

    protected function configure(): void
    {
        $this->setDescription('Transform partners csv reports to Spot2D format');
        $this->addArgument('reports-path', InputArgument::REQUIRED, 'Path to folder where reports are kept');
        $this->addArgument(
            'export-path',
            InputArgument::REQUIRED,
            'Path to folder where transformed reports will be exported'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $transformer = CsvTransformer::create();

        $filesystem = new Filesystem(new Local('/'));
        $filesystem->addPlugin(new ListFiles());

        $reportsPath = $this->makePath($input->getArgument('reports-path'), $filesystem);
        $exportPath = $this->makePath($input->getArgument('export-path'), $filesystem);

        $exportData = [];

        foreach ($filesystem->listFiles($reportsPath, true) as $file) {
            if ($file['extension'] !== 'csv') {
                continue;
            }

            $stream = $filesystem->readStream($file['path']);

            foreach ($transformer->transform($stream) as $data) {
                if (isset($exportData[$data->reportType])) {
                    $exportStream = $exportData[$data->reportType];
                } else {
                    $exportStream = fopen('php://temp', 'r+ab');
                    $exportData[$data->reportType] = $exportStream;
                }

                rewind($data->stream);
                // Step over header line if we appending report records
                if (ftell($exportStream) > 0) {
                    fgetcsv($data->stream);
                }

                $this->copyStreamToStream($data->stream, $exportStream, $data->reportType);
                fclose($data->stream);
            }
        }

        foreach ($exportData as $report => $reportStream) {
            $filesystem->putStream($exportPath . '/' . $report . '.csv', $reportStream);
        }

        return self::SUCCESS;
    }

    /**
     * @param resource $source phpcs:ignore
     * @param resource $target phpcs:ignore
     */
    private function copyStreamToStream($source, $target, string $reportType): void // phpcs:ignore
    {
        if (!in_array($reportType, [ToSkuTransformer::TYPE, ToTtoptionsTransformer::TYPE], true)) {
            stream_copy_to_stream($source, $target);

            return;
        }

        // TODO: If you need to add some logic here - refactor this part. Extract Filter service.
        while (!feof($source)) {
            $line = fgets($source);
            $hash = sha1(ToSkuTransformer::TYPE === $reportType ? $line : explode(';', $line)[1]); // phpcs:ignore

            if (isset($this->lineHashes[$hash])) {
                continue;
            }

            $this->lineHashes[$hash] = true;
            fwrite($target, $line);
        }
    }

    private function makePath(string $inputPath, Filesystem $filesystem): string
    {
        if (strpos($inputPath, '..') === false && $filesystem->has($inputPath)) {
            return $inputPath;
        }

        $inputPath = getcwd() . '/' . $inputPath;

        if ($filesystem->has($inputPath)) {
            return $inputPath;
        }

        throw new SpotException(sprintf('Path "%s" isn\'t valid', $inputPath));
    }
}
