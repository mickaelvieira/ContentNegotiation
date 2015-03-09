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
class Content implements Negotiation
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
     * {@inheritdoc}
     */
    public function getMedia(array $supported)
    {
        $negotiator = NegotiatorFactory::make(
            ContentTypeFactory::makeTypeMedia(),
            $this->getHeaderValue('Accept')
        );

        return $negotiator->negotiate($supported);
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguage(array $supported)
    {
        $negotiator = NegotiatorFactory::make(
            ContentTypeFactory::makeTypeLanguage(),
            $this->getHeaderValue('Accept-Language')
        );

        return $negotiator->negotiate($supported);
    }

    /**
     * {@inheritdoc}
     */
    public function getCharset(array $supported)
    {
        $negotiator = NegotiatorFactory::make(
            ContentTypeFactory::makeTypeCharset(),
            $this->getHeaderValue('Accept-Charset')
        );

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
