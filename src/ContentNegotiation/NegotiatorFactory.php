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

use ContentNegotiation\Header\Field;
use ContentNegotiation\Header\FieldType;

/**
 * Class NegotiatorFactory
 * @package ContentNegotiation
 */
final class NegotiatorFactory
{
    /**
     * @param \ContentNegotiation\Header\FieldType $contentType
     * @param string $headerValue
     * @return \ContentNegotiation\Negotiator
     */
    public static function make(FieldType $contentType, $headerValue)
    {
        return new Negotiator($contentType, new Field($contentType, $headerValue));
    }
}
