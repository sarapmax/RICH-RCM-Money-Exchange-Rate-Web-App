<?php

/**
 * Generate a relative URL to a named route.
 *
 * @param string $name
 * @param array $parameters
 * @param bool $withLeadingSlash
 * @return string
 */
function route_rel($name, $parameters = [], bool $withLeadingSlash = true)
{
    $uri = app('url')->route($name, $parameters, false);

    return $withLeadingSlash ? $uri : ltrim($uri, '/');
}
