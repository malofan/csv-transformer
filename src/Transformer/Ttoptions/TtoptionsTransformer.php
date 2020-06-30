<?php

declare(strict_types=1);

namespace Spot\Transformer\Ttoptions;

use Spot\Exception\SpotException;
use Spot\Transformer\BaseTransformer;

class TtoptionsTransformer extends BaseTransformer
{
    /**
     * @throws SpotException
     */
    public function getFor(string $partnerType): ToTtoptionsDataTransformer
    {
        return parent::getFor($partnerType);
    }
}
