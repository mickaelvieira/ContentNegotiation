<?php


namespace ContentNegotiation\Header;

/**
 * Class FieldType
 * @package ContentNegotiation\Header
 */
final class FieldType
{

    const LANGUAGE_TYPE = "language";
    const CHARSET_TYPE  = "charset";
    const MEDIA_TYPE    = "media";

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $defaultValue;

    /**
     * @var string
     */
    private $defaultSubTag;

    /**
     * @var string
     */
    private $valueDelimiter;

    /**
     * @param string $type
     * @param string $defaultValue
     * @param string $defaultSubTag
     * @param string $valueDelimiter
     */
    public function __construct($type, $defaultValue, $defaultSubTag, $valueDelimiter)
    {
        $this->type           = (string)$type;
        $this->defaultValue   = (string)$defaultValue;
        $this->defaultSubTag  = (string)$defaultSubTag;
        $this->valueDelimiter = (string)$valueDelimiter;
    }

    /**
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @return string
     */
    public function getDefaultSubTag()
    {
        return $this->defaultSubTag;
    }

    /**
     * @return string
     */
    public function getValueDelimiter()
    {
        return $this->valueDelimiter;
    }

    /**
     * @return bool
     */
    public function isMediaType()
    {
        return $this->type === self::MEDIA_TYPE;
    }

    /**
     * @return bool
     */
    public function isLanguageType()
    {
        return $this->type === self::LANGUAGE_TYPE;
    }

    /**
     * @return bool
     */
    public function isCharsetType()
    {
        return $this->type === self::CHARSET_TYPE;
    }
}
