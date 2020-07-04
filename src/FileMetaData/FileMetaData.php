<?php

declare(strict_types=1);

namespace Spot\FileMetaData;

use Spot\Exception\SpotException;

class FileMetaData
{
    private $fileMetaDataSet;

    /**
     * @param FileMetaDataStrategy[] $fileMetaDataSet
     */
    public function __construct(iterable $fileMetaDataSet)
    {
        $this->fileMetaDataSet = $fileMetaDataSet;
    }

    public function getFor(string $partnerType, string $reportType): FileMetaDataInterface
    {
        foreach ($this->fileMetaDataSet as $fileMetaData) {
            if ($fileMetaData->supports($partnerType, $reportType)) {

                return $fileMetaData;
            }
        }

        throw new SpotException(sprintf('FileMetaData for partner type "%s" doesn\'t exists', $partnerType));
    }
}
