<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Stock;

use Iterator;
use Spot\DTO\StockRecord;
use Spot\Exception\SpotException;
use Spot\Transformer\Stock\StockTransformer;
use PHPUnit\Framework\TestCase;
use Spot\Transformer\Stock\ToStockDataTransformer;
use Spot\Transformer\TransformerStrategy;

class StockTransformerTest extends TestCase
{
    public function test(): void
    {
        $transformer = new class implements TransformerStrategy, ToStockDataTransformer {
            /**
             * @param mixed[] $record
             */
            public function transform(array $record): StockRecord
            {
                // TODO: Implement transform() method.
            }

            public function supports(string $partnerType): bool
            {
                return true;
            }

            public function transformAll(Iterator $records): iterable
            {
                // TODO: Implement transformAll() method.
            }
        };
        $provider = new StockTransformer([$transformer]);

        self::assertInstanceOf(ToStockDataTransformer::class, $provider->getFor('test'));
    }

    /**
     * @test
     */
    public function exceptionThrown(): void
    {
        $provider = new StockTransformer([]);

        $this->expectException(SpotException::class);
        $provider->getFor('test');
    }
}
