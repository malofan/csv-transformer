<?php

declare(strict_types=1);

namespace Spot\Transformer\Ttoptions;

use Spot\Transformer\FromSalesTransformer;

abstract class ToTtoptionsTransformer extends FromSalesTransformer
{
    public const TYPE = 'ttoptions';
    
    public function getType(): string
    {
        return self::TYPE;
    }
}
