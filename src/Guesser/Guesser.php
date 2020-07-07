<?php

declare(strict_types=1);

namespace Spot\Guesser;

use Spot\DTO\PartnerRecords;
use Spot\Exception\SpotException;
use Spot\Reader;

class Guesser
{
    private $choices;
    private $reader;

    /**
     * @param Choice[] $choices
     */
    public function __construct(iterable $choices, Reader $reader)
    {
        $this->choices = $choices;
        $this->reader = $reader;
    }

    /**
     * @param resource $stream phpcs:ignore
     * @throws SpotException
     */
    public function guessBy($stream): PartnerRecords //phpcs:ignore
    {
        foreach ($this->choices as $choice) {
            $reader = $this->reader->read($stream, $choice);

            if (empty(array_diff($choice->headerFields(), $reader->getHeader()))) {

                return new PartnerRecords($choice->partner(), $choice->report(), $reader->getRecords());
            }
        }

        throw new SpotException('Cann\'t guess type by provided header');
    }
}
