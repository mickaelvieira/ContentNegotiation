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
use ContentNegotiation\Header\FieldTypeFactory;

/**
 * Class NegotiatorFactory
 * @package ContentNegotiation
 */
final class NegotiatorFactory
{
    /**
     * @param string|array $headerValue
     * @return \ContentNegotiation\Negotiator
     */
    public static function makeLanguageNegotiator($headerValue)
    {
        $type = FieldTypeFactory::makeTypeLanguage();
        return new Negotiator($type, new Field($type, $headerValue));
    }

    /**
     * @param string|array $headerValue
     * @return \ContentNegotiation\Negotiator
     */
    public static function makeCharsetNegotiator($headerValue)
    {
        $type = FieldTypeFactory::makeTypeCharset();
        return new Negotiator($type, new Field($type, $headerValue));
    }

    /**
     * @param string|array $headerValue
     * @return \ContentNegotiation\Negotiator
     */
    public static function makeMediaNegotiator($headerValue)
    {
        $type = FieldTypeFactory::makeTypeMedia();
        return new Negotiator($type, new Field($type, $headerValue));
    }
}
