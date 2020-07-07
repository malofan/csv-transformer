<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Sku;

use Spot\Exception\InvalidRecordException;
use Spot\Repository\DistributorRepository;
use Spot\Transformer\Sku\FromBadmData;
use PHPUnit\Framework\TestCase;

class FromBadmTest extends TestCase
{
    /**
     * @test
     */
    public function supports(): void
    {
        self::assertTrue(
            (new FromBadmData($this->createMock(DistributorRepository::class)))->supports('badm', 'sales')
        );
    }

    /**
     * @test
     */
    public function transform(): void
    {
        $this->expectException(InvalidRecordException::class);
        (new FromBadmData($this->createMock(DistributorRepository::class)))->transform([1, 2, 3]);
    }

    /**
     * @test
     */
    public function getPartnerType(): void
    {
        self::assertSame('badm', (new FromBadmData($this->createMock(DistributorRepository::class)))->getPartnerType());
    }

    /**
     * @test
     */
    public function getType(): void
    {
        self::assertSame('sku', (new FromBadmData($this->createMock(DistributorRepository::class)))->getType());
    }
}
