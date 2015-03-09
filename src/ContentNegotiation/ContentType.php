<?php


namespace ContentNegotiation;

use ContentNegotiation\Header\FieldType;

/**
 * Class Type
 * @package ContentNegotiation
 */
final class ContentType
{
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
        return $this->type === FieldType::MEDIA_TYPE;
    }

    /**
     * @return bool
     */
    public function isLanguageType()
    {
        return $this->type === FieldType::LANGUAGE_TYPE;
    }

    /**
     * @return bool
     */
    public function isCharsetType()
    {
        return $this->type === FieldType::CHARSET_TYPE;
    }
}
