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

/**
 * Class NegotiatorFactory
 * @package ContentNegotiation
 */
final class NegotiatorFactory
{
    /**
     * @param ContentType $contentType
     * @param string $headerValue
     * @return \ContentNegotiation\Negotiator
     */
    public static function make(ContentType $contentType, $headerValue)
    {
        $acceptHeader = new Field($contentType, $headerValue);

        return new Negotiator($contentType, $acceptHeader);
    }
}
