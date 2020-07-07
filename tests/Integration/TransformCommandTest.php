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
        $input = $this->createMock(InputInterface::class);
        $input
            ->method('getArgument')
            ->willReturnOnConsecutiveCalls(__DIR__ . '/PartnerReports/', __DIR__ . '/TempTransformedReports/');
        $filesystem = new Filesystem(new Local(__DIR__));
        $filesystem->addPlugin(new ListFiles());
        $filesystem->createDir('TempTransformedReports');

        (new TransformCommand())->execute($input, $output);

        foreach ($filesystem->listFiles('TransformedReports/', true) as $expectedFile) {
            self::assertFileEquals(
                $expectedFile['path'],
                str_replace('TransformedReports', 'TempTransformedReports', $expectedFile['path'])
            );
        }

        $filesystem->deleteDir('TempTransformedReports');
    }
}
