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

namespace ContentNegotiation\AcceptHeader;

/**
 * Class Value
 * @package ContentNegotiation\AcceptHeader
 */
abstract class Value
{
    /**
     * @var \ContentNegotiation\AcceptHeader\ValueRange
     */
    protected $valueRange;

    /**
     * @var float
     */
    protected $defaultQuality = 1;

    /**
     * @var string
     */
    protected static $delimiter = "";

    /**
     * @var
     */
    protected $params;
    /**
     * @var int
     */
    protected $index = 0;

    /**
     * @param string $pieces
     * @param int    $index
     */
    public function __construct($pieces, $index = null)
    {
        $this->index = (int)$index;

        $pieces = explode(";", $this->cleanHeaderString($pieces));
        $values = array_shift($pieces);

        if ($values) {
            $this->valueRange = new ValueRange($values, static::getDelimiter());
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
        return (string)$this->valueRange;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $str = $this->getValue();
        $str = $this->joinParameters($str);

        return $str;
    }

    /**
     * @return bool
     */
    public function hasAcceptAllTag()
    {
        return ($this->valueRange->getValue() === '*');
    }

    /**
     * @return bool
     */
    abstract public function hasAcceptAllSubTag();

    /**
     * @param string $tag
     * @return bool
     */
    public function hasTag($tag)
    {
        return ($this->valueRange->getValue() === $tag);
    }

    /**
     * @param string $subSubTag
     * @return bool
     */
    public function hasSubTag($subSubTag)
    {
        return ($this->valueRange->getSubValue() === $subSubTag);
    }

    /**
     * @param string $value
     * @return bool
     */
    public function hasValue($value)
    {
        return ((string)$this->valueRange === $value);
    }

    /**
     * @param string $header
     * @return string
     */
    private function cleanHeaderString($header)
    {
        return preg_replace("/\s/", "", (string)$header);
    }

    /**
     * @param $name
     * @return \ContentNegotiation\AcceptHeader\Param|null
     */
    public function getParam($name)
    {
        return $this->params->getParam($name);
    }

    /**
     * @param string $str
     * @return string
     */
    protected function joinParameters($str)
    {
        if (!empty($str)) {
            $str .= ($this->params->count() > 0) ? ';' . (string)$this->params : '';
        }

        return $str;
    }


    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }
}
