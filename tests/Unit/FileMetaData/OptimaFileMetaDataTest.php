<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\FileMetaData;

use Spot\FileMetaData\OptimaFileMetaData;
use PHPUnit\Framework\TestCase;

class OptimaFileMetaDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new OptimaFileMetaData())->supports('optima'));
    }
}
