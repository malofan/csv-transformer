<?php

declare(strict_types=1);

namespace Spot\Transformer;

interface TransformerStrategy
{
    public const TAG_NAME = 'transformer.strategy';
    public function supports(string $partnerType, string $reportType): bool;
}
