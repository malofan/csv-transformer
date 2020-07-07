<?php

declare(strict_types=1);

namespace Spot\Repository;

use Spot\Exception\SpotException;

class JsonDistributorRepository implements DistributorRepository
{
    private $storage;

    public function __construct(string $data)
    {
        $this->storage = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws SpotException
     */
    public function getIdBy(string $name, string $partnerType, ?string $reportType = null): int
    {
        if (!isset($this->storage[$partnerType][$reportType])) {
            throw new SpotException(
                sprintf('Distributor list for "%s" report was not found for partner "%s"', $reportType, $partnerType)
            );
        }

        $list = $this->storage[$partnerType][$reportType];

        foreach ($list as $item) {
            if ($item['branch'] === $name) {

                return $item['Spot2Did'];
            }
        }

        throw new SpotException(
            sprintf(
                'Distributor with name "%s" in %s report was not found for partner "%s"',
                $name,
                $reportType,
                $partnerType
            )
        );
    }
}
