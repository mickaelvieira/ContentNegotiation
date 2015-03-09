<?php


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
