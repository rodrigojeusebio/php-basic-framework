<?php

namespace Libs;

final class Arr
{
    public static function wrap(mixed $value): array
    {
        if (! is_array($value))
        {
            $value = [$value];
        }

        return $value;
    }

}