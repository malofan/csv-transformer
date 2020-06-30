<?php

namespace Spot\Tests\Unit\Transformer\Delivery;

use Spot\DTO\DeliveryRecord;
use Spot\Exception\SpotException;
use Spot\Transformer\Delivery\DeliveryTransformer;
use PHPUnit\Framework\TestCase;
use Spot\Transformer\Delivery\ToDeliveryDataTransformer;
use Spot\Transformer\TransformerStrategy;

class DeliveryTransformerTest extends TestCase
{
    public function test()
    {
        $transformer = new class implements TransformerStrategy, ToDeliveryDataTransformer {
            public function transform(array $record): DeliveryRecord
            {
                // TODO: Implement transform() method.
            }

            public function supports(string $partnerType): bool
            {
                return true;
            }
        };
        $provider = new DeliveryTransformer([$transformer]);

        self::assertInstanceOf(ToDeliveryDataTransformer::class, $provider->getFor('test'));
    }

    /**
     * @test
     */
    public function exceptionThrown(): void
    {
        $provider = new DeliveryTransformer([]);

        $this->expectException(SpotException::class);
        $provider->getFor('test');
    }
}
