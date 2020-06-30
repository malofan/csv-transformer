<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Ttoptions;

use Spot\DTO\TtoptionsRecord;
use Spot\Exception\SpotException;
use Spot\Transformer\Ttoptions\TtoptionsTransformer;
use PHPUnit\Framework\TestCase;
use Spot\Transformer\Ttoptions\ToTtoptionsDataTransformer;
use Spot\Transformer\TransformerStrategy;

class TtoptionsTransformerTest extends TestCase
{
    public function test(): void
    {
        $transformer = new class implements TransformerStrategy, ToTtoptionsDataTransformer {
            /**
             * @param mixed[] $record
             */
            public function transform(array $record): TtoptionsRecord
            {
                // TODO: Implement transform() method.
            }

            public function supports(string $partnerType): bool
            {
                return true;
            }
        };
        $provider = new TtoptionsTransformer([$transformer]);

        self::assertInstanceOf(ToTtoptionsDataTransformer::class, $provider->getFor('test'));
    }

    /**
     * @test
     */
    public function exceptionThrown(): void
    {
        $provider = new TtoptionsTransformer([]);

        $this->expectException(SpotException::class);
        $provider->getFor('test');
    }
}
