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
        return $this->negotiate('media', $supported);
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguage(array $supported)
    {
        return $this->negotiate('language', $supported);
    }

    /**
     * {@inheritdoc}
     */
    public function getCharset(array $supported)
    {
        return $this->negotiate('charset', $supported);
    }

    /**
     * @param string $name
     * @param array $supported
     * @return null|string
     */
    private function negotiate($name, array $supported)
    {
        $negotiator = $this->getNegotiator($name);
        return $negotiator->negotiate($supported);
    }

    /**
     * @param string $name
     * @return \ContentNegotiation\Negotiator
     */
    private function getNegotiator($name)
    {
        $headerValue = $this->getAcceptHeaderValues($name);
        return Factory::build($name, $headerValue);
    }

    /**
     * @param string $name
     * @return string
     */
    private function getAcceptHeaderValues($name)
    {
        $type = null;
        switch ($name) {
            case 'media':
                $type = 'Accept';
                break;
            case 'charset':
                $type = 'Accept-Charset';
                break;
            case 'language':
                $type = 'Accept-Language';
                break;
        }
        return ($type && array_key_exists($type, $this->headers)) ? $this->headers[$type] : '';
    }
}
