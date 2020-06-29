<?php

declare(strict_types=1);

namespace Spot\Exception;

class InvalidRecordException extends SpotException
{
    public static function notProvidedField(string $field): self
    {
        return new self(sprintf('Field "%s" was not provided in record', $field));
    }
}
