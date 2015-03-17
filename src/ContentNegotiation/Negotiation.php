<?php

/*
 * This file is part of ContentNegotiation, a php implementation
 * of the server driven negotiation
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContentNegotiation;

/**
 * Class Content
 * @package ContentNegotiation
 */
final class Negotiation
{
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @param array $headers
     */
    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @param array|string $supported
     * @return \ContentNegotiation\Header\Value|null
     */
    public function getMedia($supported)
    {
        $negotiator = NegotiatorFactory::makeMediaNegotiator($this->getHeaderValue('Accept'));
        return $negotiator->negotiate($supported);
    }

    /**
     * @param array|string $supported
     * @return \ContentNegotiation\Header\Value|null
     */
    public function getLanguage($supported)
    {
        $negotiator = NegotiatorFactory::makeLanguageNegotiator($this->getHeaderValue('Accept-Language'));
        return $negotiator->negotiate($supported);
    }

    /**
     * @param array|string $supported
     * @return \ContentNegotiation\Header\Value|null
     */
    public function getCharset($supported)
    {
        $negotiator = NegotiatorFactory::makeCharsetNegotiator($this->getHeaderValue('Accept-Charset'));
        return $negotiator->negotiate($supported);
    }

    /**
     * @param $type
     * @return string
     */
    private function getHeaderValue($type)
    {
        return ($type && array_key_exists($type, $this->headers)) ? $this->headers[$type] : '';
    }
}
