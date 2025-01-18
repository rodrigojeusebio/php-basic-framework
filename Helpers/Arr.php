<?php

namespace Helpers;

final class Arr
{
    /**
     * Wrap the current value in array if the value if not and array  
     */
    public static function wrap(mixed $value): array
    {
        if (! is_array($value))
        {
            $value = [$value];
        }

        return $value;
    }

}