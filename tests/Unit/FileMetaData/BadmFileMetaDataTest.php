<?php

namespace Spot\Tests\Unit\FileMetaData;

use Spot\FileMetaData\BadmFileMetaData;
use PHPUnit\Framework\TestCase;

class BadmFileMetaDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new BadmFileMetaData())->supports('badm'));
    }
}
