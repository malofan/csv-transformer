<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Ttoptions;

use Spot\Exception\InvalidRecordException;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\Ttoptions\FromBadmData;
use PHPUnit\Framework\TestCase;

class FromBadmSalesDataTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue((new FromBadmData($this->createMock(DistributorRepository::class)))->supports('badm'));
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromBadmData($this->createMock(DistributorRepository::class)))->transform([1, 2, 3]);
    }
}
