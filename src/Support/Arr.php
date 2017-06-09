<?php

namespace Brainfab\Toggl\Support;

class Arr
{
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param \ArrayAccess|array $array
     * @param string|callable    $key
     * @param mixed              $default
     *
     * @return mixed
     */
    public static function get($array, $key, $default = null)
    {
        if ($key === null) {
            return $array;
        }

        if (is_callable($key) && !is_string($key)) {
            $key = call_user_func($key, $array);
        }

        if (is_array($array) && isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if ((!is_array($array) || !array_key_exists($segment, $array)) &&
                (!$array instanceof \ArrayAccess || !$array->offsetExists($segment))
            ) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param array        $array
     * @param array|string $keys
     * @param bool         $appendUndefinedKeys
     *
     * @return array
     */
    public static function only($array, $keys, $appendUndefinedKeys = false)
    {
        $array = array_intersect_key($array, array_flip((array) $keys));

        if ($appendUndefinedKeys) {
            foreach ($keys as $key) {
                if (!array_key_exists($key, $array)) {
                    $array[$key] = null;
                }
            }
        }

        return $array;
    }
}
