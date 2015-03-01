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
abstract class Value extends Entity
{
    /**
     * @var \ContentNegotiation\AcceptHeader\ValueRange
     */
    protected $valueRange;

    /**
     * @var float
     */
    protected $defaultQuality = 1.0;

    /**
     * @var string
     */
    protected static $delimiter = "";

    /**
     * @var
     */
    protected $params = [];

    /**
     * @param string $pieces
     */
    public function __construct($pieces)
    {
        $pieces = explode(";", $this->cleanHeaderString($pieces));
        $values = array_shift($pieces);

        if ($values) {
            $this->valueRange = new ValueRange($values, static::getDelimiter());
            $this->addParams($pieces);
            $this->addDefaultQualityIfNoneSpecified();
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
        $str = $this->joinParameters($str, $this->params);

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
     * @param $pieces
     */
    protected function addParams(array $pieces)
    {
        foreach ($pieces as $piece) {
            $param = explode("=", $piece);
            if (count($param) === 2) {
                $this->addParam(new Param($param[0], $param[1]));
            }
        }
    }

    /**
     * @param \ContentNegotiation\AcceptHeader\Param $param
     */
    protected function addParam(Param $param)
    {
        array_push($this->params, $param);
    }

    /**
     * @param $name
     * @return \ContentNegotiation\AcceptHeader\Param|null
     */
    public function getParam($name)
    {
        $param = null;

        foreach ($this->params as $p) {
            /** @var $p Param */
            if ($p->getName() === $name) {
                $param = $p;
                break;
            }
        }

        return $param;
    }

    /**
     * @param string $str
     * @param array $params
     * @return string
     */
    protected function joinParameters($str, array $params)
    {
        $strParams = "";

        foreach ($params as $param) {
            if (!empty($strParams)) {
                $strParams .= ";";
            }
            $strParams .= (string)$param;
        };

        if (!empty($str)) {
            $str .= !empty($params) ? ';' . $strParams : '';
        }

        return $str;
    }

    private function addDefaultQualityIfNoneSpecified()
    {
        if (!$this->getParam('q')) {
            $this->addParam(new Param('q', $this->defaultQuality));
        }
    }
}
