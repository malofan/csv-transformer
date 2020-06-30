<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Sku;

use Spot\DTO\SkuRecord;
use Spot\Exception\SpotException;
use Spot\Transformer\Sku\SkuTransformer;
use PHPUnit\Framework\TestCase;
use Spot\Transformer\Sku\ToSkuDataTransformer;
use Spot\Transformer\TransformerStrategy;

class SkuTransformerTest extends TestCase
{
    public function test(): void
    {
        $transformer = new class implements TransformerStrategy, ToSkuDataTransformer {
            /**
             * @param mixed[] $record
             */
            public function transform(array $record): SkuRecord
            {
                // TODO: Implement transform() method.
            }

            public function supports(string $partnerType): bool
            {
                return true;
            }
        };
        $provider = new SkuTransformer([$transformer]);

        self::assertInstanceOf(ToSkuDataTransformer::class, $provider->getFor('test'));
    }

    /**
     * @test
     */
    public function exceptionThrown(): void
    {
        $provider = new SkuTransformer([]);

        $this->expectException(SpotException::class);
        $provider->getFor('test');
    }
}
