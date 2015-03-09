<?php


namespace ContentNegotiation;

use ContentNegotiation\Header\FieldType;

/**
 * Class TypeFactory
 * @package ContentNegotiation
 */
final class ContentTypeFactory
{
    /**
     * @return \ContentNegotiation\ContentType
     */
    public static function makeTypeMedia()
    {
        return new ContentType(FieldType::MEDIA_TYPE, "*/*", "*", "/");
    }

    /**
     * @return \ContentNegotiation\ContentType
     */
    public static function makeTypeLanguage()
    {
        return new ContentType(FieldType::LANGUAGE_TYPE, "*", "*", "-");
    }

    /**
     * @return \ContentNegotiation\ContentType
     */
    public static function makeTypeCharset()
    {
        return new ContentType(FieldType::CHARSET_TYPE, "*", "", "");
    }
}
