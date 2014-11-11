<?php

namespace ContentNegotiation;

/**
 * Class Negotiation
 * @package ContentNegotiation
 * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec12
 */
interface Negotiation
{
    /**
     * @param array $supported
     * @return null|string
     */
    public function getMedia(array $supported);

    /**
     * @param array $supported
     * @return null|string
     */
    public function getLanguage(array $supported);

    /**
     * @param array $supported
     * @return null|string
     */
    public function getCharset(array $supported);
}
