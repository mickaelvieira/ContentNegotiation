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

namespace ContentNegotiation\Header;

/**
 * Class TypeFactory
 * @package ContentNegotiation
 */
final class FieldTypeFactory
{
    /**
     * @return \ContentNegotiation\Header\FieldType
     */
    public static function makeTypeMedia()
    {
        return new FieldType(FieldType::MEDIA_TYPE, "*/*", "*", "/");
    }

    /**
     * @return \ContentNegotiation\Header\FieldType
     */
    public static function makeTypeLanguage()
    {
        return new FieldType(FieldType::LANGUAGE_TYPE, "*", "*", "-");
    }

    /**
     * @return \ContentNegotiation\Header\FieldType
     */
    public static function makeTypeCharset()
    {
        return new FieldType(FieldType::CHARSET_TYPE, "*", "", "");
    }
}
