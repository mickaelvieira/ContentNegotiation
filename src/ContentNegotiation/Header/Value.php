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
 * Class Value
 * @package ContentNegotiation\Header
 */
class Value
{
    /**
     * @var \ContentNegotiation\Header\ValueRange
     */
    protected $value;

    /**
     * @var string
     */
    protected static $delimiter = "";

    /**
     * @var \ContentNegotiation\Header\Params
     */
    protected $params;

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @param        $pieces
     * @param null   $position
     * @param string $delimiter
     */
    public function __construct($pieces, $position = null, $delimiter = "")
    {
        $this->position = (int)$position;

        self::$delimiter = $delimiter;

        $pieces = explode(";", $pieces);
        $values = array_shift($pieces);

        if ($values) {
            $this->value = new ValueRange($values, static::getDelimiter());
            $this->params = new Params($pieces);
        }
    }

    /**
     * @return float
     */
    public function getQuality()
    {
        $quality = $this->getParam('q');
        return (float)$quality->getValue();
    }

    /**
     * @return string
     */
    public static function getDelimiter()
    {
        return static::$delimiter;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return (string)$this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->getValue()) {
            if ($this->params->count() > 0) {
                $str = sprintf('%s;%s', $this->value, $this->params);
            } else {
                $str = sprintf('%s', $this->value);
            }
        } else {
            $str = "";
        }
        return $str;
    }

    /**
     * @return bool
     */
    public function hasAcceptAllTag()
    {
        return ($this->value->getValue() === '*');
    }

    /**
     * @return bool
     */
    public function hasAcceptAllSubTag()
    {
        if (static::getDelimiter() === "") {
            return false;
        } elseif (static::getDelimiter() === "-") {
            return $this->hasSubTag(null);
        } elseif (static::getDelimiter() === "/") {
            return $this->hasSubTag('*');
        }
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function hasTag($tag)
    {
        return ($this->value->getValue() === $tag);
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->value->getValue();
    }

    /**
     * @param string $subTag
     * @return bool
     */
    public function hasSubTag($subTag)
    {
        return ($this->value->getSubValue() === $subTag);
    }

    /**
     * @return string
     */
    public function getSubTag()
    {
        return $this->value->getSubValue();
    }

    /**
     * @param string $value
     * @return bool
     */
    public function isEqual($value)
    {
        return ((string)$this->value === $value);
    }

    /**
     * @param $name
     * @return \ContentNegotiation\Header\Param|null
     */
    public function getParam($name)
    {
        return $this->params->getParam($name);
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return int
     */
    public function countParams()
    {
        return $this->params->count();
    }
}
