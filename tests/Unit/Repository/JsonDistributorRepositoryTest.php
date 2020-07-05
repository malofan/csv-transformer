<?php

declare(strict_types=1);

namespace Spot\Tests\Unit\Repository;

use PHPUnit\Framework\TestCase;
use Spot\Repository\JsonDistributorRepository;

class JsonDistributorRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function getIdBy(): void
    {
        $expectedID = 23;
        $data = [
            'badm' => [
                'sales' => [
                    [
                        'branch' => 'Test branch',
                        'Spot2Did' => $expectedID
                    ]
                ]
            ]
        ];

        $repository = new JsonDistributorRepository(json_encode($data));

        $id = $repository->getIdBy('Test branch', 'badm', 'sales');

        $this->assertSame($expectedID, $id);
    }
}