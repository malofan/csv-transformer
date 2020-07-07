<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer;

use Iterator;
use PHPUnit\Framework\TestCase;
use Spot\Transformer\Transformer;
use Spot\Transformer\TransformerProvider;
use Spot\Transformer\TransformerStrategy;

class TransformerProviderTest extends TestCase
{
    public function test(): void
    {
        $transformer = new class implements TransformerStrategy, Transformer {

            public function supports(string $partnerType, string $reportType): bool
            {
                return true;
            }

            public function transformAll(Iterator $records): iterable // phpcs:ignore
            {
            }

            public function transform(array $record) // phpcs:ignore
            {
            }

            public function getType(): string
            {
            }
        };
        $provider = new TransformerProvider([$transformer]);

        self::assertInstanceOf(Transformer::class, $provider->getFor('test', 'test')->current());
    }
}
