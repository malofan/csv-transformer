<?php

declare(strict_types=1);

namespace Spot\Transformer;

class TransformerProvider
{
    private $transformers;

    /**
     * @param TransformerStrategy[] $transformers
     */
    public function __construct(iterable $transformers) // phpcs:ignore
    {
        $this->transformers = $transformers;
    }

    /**
     * @return Transformer[]
     */
    public function getFor(string $partnerType, string $reportType): iterable
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($partnerType, $reportType)) {

                yield $transformer;
            }
        }
    }
}
