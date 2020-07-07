<?php

declare(strict_types=1);

namespace Spot\Transformer;

use Iterator;

interface Transformer
{
    public function transformAll(Iterator $records): iterable; //phpcs:ignore
    public function transform(array $record); //phpcs:ignore
    public function getType(): string;
}
