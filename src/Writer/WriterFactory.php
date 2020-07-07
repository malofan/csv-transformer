<?php

declare(strict_types=1);

namespace Spot\Writer;

use Spot\Exception\SpotException;

class WriterFactory
{
    /**
     * @var WriterStrategy[]
     */
    private const WRITERS = [
        Delivery::class,
        Sku::class,
        Stock::class,
        Ttoptions::class,
    ];

    public function getFor(string $reportType): Writer
    {
        foreach (self::WRITERS as $writer) {
            if ($writer::supports($reportType)) {
                return new $writer();
            }
        }

        throw new SpotException(sprintf('Writer for report of type "%s" isn\'t implemented', $reportType));
    }
}
