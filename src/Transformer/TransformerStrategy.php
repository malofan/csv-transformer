<?php

declare(strict_types=1);

namespace Spot\Transformer;

interface TransformerStrategy
{
    public function supports(string $partnerType): bool;
}
