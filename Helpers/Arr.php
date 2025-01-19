<?php

declare(strict_types=1);

namespace Helpers;

final class Arr
{
    /**
     * Wrap the current value in array if the value if not and array
     *
     * @template Tvalue
     *
     * @param  Tvalue | array<Tvalue>  $value
     * @return array<Tvalue>
     */
    public static function wrap(mixed $value): array
    {
        if (! is_array($value))
        {
            $value = [$value];
        }

        return $value;
    }

    /**
     * @template Tvalue
     * @param array<Tvalue> $array
     * @return Tvalue is empty-array ? false : Tvalue
     */
    public static function first_value(array &$array): mixed
    {
        return reset($array);
    }
}
