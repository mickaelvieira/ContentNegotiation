<?php

namespace ContentNegotiation;

/**
 * Class Factory
 * @package ContentNegotiation
 */
final class Factory
{
    /**
     * @param string $name
     * @param string $headerValue
     * @return \ContentNegotiation\Negotiator
     */
    public static function build($name, $headerValue)
    {
        $negotiatorClass   = self::getNegotiatorClassName($name);
        $acceptHeaderClass = self::getAcceptHeaderClassName($name);

        $acceptHeader = new $acceptHeaderClass($headerValue);

        return new $negotiatorClass($acceptHeader);
    }

    /**
     * @param $name
     * @return \ContentNegotiation\Negotiator
     */
    private function getNegotiatorClassName($name)
    {
        return __NAMESPACE__ . "\\Negotiator\\" . self::getClassName($name);
    }

    /**
     * @param string $name
     * @return \ContentNegotiation\AcceptHeader
     */
    private function getAcceptHeaderClassName($name)
    {
        return __NAMESPACE__ . "\\AcceptHeader\\Values\\" . self::getClassName($name);
    }

    /**
     * @param string $name
     * @return string
     */
    private function getClassName($name)
    {
        return ucfirst(strtolower($name));
    }
}
