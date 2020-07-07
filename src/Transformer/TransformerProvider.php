<?php

declare(strict_types=1);

namespace Spot\Transformer;

use Spot\Exception\SpotException;

abstract class BaseTransformer
{
    private $transformers;

    /**
     * @param TransformerStrategy[] $transformers
     */
    public function __construct(iterable $transformers) // phpcs:ignore
    {
        $this->transformers = $transformers;
    }

    public function getFor(string $partnerType) // phpcs:ignore
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($partnerType)) {

                return $transformer;
            }
        }

        $classParts = explode('\\', static::class);

        throw new SpotException(
            sprintf('%s for partner type "%s" doesn\'t exists', array_pop($classParts), $partnerType)
        );
    }
}
