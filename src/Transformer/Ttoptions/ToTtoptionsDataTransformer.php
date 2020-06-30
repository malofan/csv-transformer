<?php

declare(strict_types=1);

namespace Spot\Transformer\Ttoptions;

use Spot\DTO\TtoptionsRecord;

interface ToTtoptionsDataTransformer
{
    public const TAG_NAME = 'ttoptions.data.transformer.strategy';

    /**
     * @param mixed[] $record
     */
    public function transform(array $record): TtoptionsRecord;
}
