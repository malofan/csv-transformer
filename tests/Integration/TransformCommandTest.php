<?php

declare(strict_types=1);

namespace Spot\Tests\Integration;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Plugin\ListFiles;
use Spot\Command\TransformCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TransformCommandTest extends TestCase
{
    public function test(): void
    {
        $output = $this->createConfiguredMock(OutputInterface::class, []);


        foreach (['badm', 'venta', 'optima'] as $partner) {
            $input = $this->createMock(InputInterface::class);
            $input
                ->method('getArgument')
                ->willReturnOnConsecutiveCalls(
                    __DIR__ . '/PartnerReports/' . $partner,
                    __DIR__ . '/TempTransformedReports/' . $partner . '/'
                );
            $filesystem = new Filesystem(new Local(__DIR__));
            $filesystem->addPlugin(new ListFiles());
            $filesystem->createDir('TempTransformedReports/' . $partner);

            (new TransformCommand())->execute($input, $output);

            foreach ($filesystem->listFiles('TransformedReports/' . $partner, true) as $expectedFile) {
                $actualFilePath = str_replace('TransformedReports', 'TempTransformedReports', $expectedFile['path']);
                self::assertFileEquals(
                    $expectedFile['path'],
                    $actualFilePath,
                    sprintf('Files %s and %s are not equal', $expectedFile['path'], $actualFilePath)
                );
            }

            $filesystem->deleteDir('TempTransformedReports/' . $partner);
        }

        $filesystem->deleteDir('TempTransformedReports');
    }
}
