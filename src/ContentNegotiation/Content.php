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

use ContentNegotiation\Header\FieldType;

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
        return $this->negotiate(FieldType::MEDIA_TYPE, $supported);
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguage(array $supported)
    {
        return $this->negotiate(FieldType::LANGUAGE_TYPE, $supported);
    }

    /**
     * {@inheritdoc}
     */
    public function getCharset(array $supported)
    {
        return $this->negotiate(FieldType::CHARSET_TYPE, $supported);
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
            case FieldType::MEDIA_TYPE:
                $type = 'Accept';
                break;
            case FieldType::CHARSET_TYPE:
                $type = 'Accept-Charset';
                break;
            case FieldType::LANGUAGE_TYPE:
                $type = 'Accept-Language';
                break;
        }
        return ($type && array_key_exists($type, $this->headers)) ? $this->headers[$type] : '';
    }
}
