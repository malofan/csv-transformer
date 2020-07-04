<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Ttoptions;

use Spot\Exception\InvalidRecordException;
use Spot\Transformer\Ttoptions\FromOptimaData;
use PHPUnit\Framework\TestCase;

class FromOptimaSalesDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new FromOptimaData())->supports('optima'));
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromOptimaData())->transform([1, 2, 3]);
    }
}
