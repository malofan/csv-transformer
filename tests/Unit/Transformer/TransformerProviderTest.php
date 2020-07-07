<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Transformer\Delivery;

use Spot\DTO\DeliveryRecord;
use Spot\Exception\SpotException;
use Spot\Transformer\FromSalesTransformer;
use PHPUnit\Framework\TestCase;
use Spot\Transformer\Delivery\ToDeliveryDataTransformer;
use Spot\Transformer\TransformerStrategy;

class DeliveryTransformerTest extends TestCase
{
    public function test(): void
    {
        $transformer = new class implements TransformerStrategy, ToDeliveryDataTransformer {
            /**
             * @param mixed[] $record
             */
            public function transform(array $record): DeliveryRecord
            {
                // TODO: Implement transform() method.
            }

            public function supports(string $partnerType): bool
            {
                return true;
            }
        };
        $provider = new FromSalesTransformer([$transformer]);

        self::assertInstanceOf(ToDeliveryDataTransformer::class, $provider->getFor('test'));
    }

    /**
     * @test
     */
    public function exceptionThrown(): void
    {
        $provider = new \Spot\Transformer\FromSalesTransformer([]);

        $this->expectException(SpotException::class);
        $provider->getFor('test');
    }
}
