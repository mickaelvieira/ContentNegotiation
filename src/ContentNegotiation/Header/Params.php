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
 * Class Params
 * @package ContentNegotiation\Header
 */
final class Params implements \Countable, \IteratorAggregate
{
    /**
     * @var float
     */
    private $defaultQuality = 1;

    /**
     * @var \ContentNegotiation\Header\Param[]
     */
    private $params = [];

    /**
     * @param array $pieces
     */
    public function __construct(array $pieces = [])
    {
        foreach ($pieces as $piece) {
            $param = explode("=", $piece);
            if (count($param) === 2) {
                $this->add($param[0], $param[1]);
            }
        }
        $this->setQualityParameterToDefaultIfNoneIsSpecified();
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->params);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->params);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(";", array_map(function (Param $param) {
            return (string)$param;
        }, $this->params));
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param string $name
     * @return \ContentNegotiation\Header\Param|null
     */
    public function getParam($name)
    {
        $param = null;
        foreach ($this->params as $p) {
            /** @var Param $p */
            if ($p->getName() === $name) {
                $param = $p;
                break;
            }
        }
        return $param;
    }

    /**
     * @param string $name
     * @param string $value
     */
    private function add($name, $value)
    {
        $param = new Param(
            trim($name),
            trim($value)
        );
        array_push($this->params, $param);
    }

    /**
     *
     */
    private function setQualityParameterToDefaultIfNoneIsSpecified()
    {
        if (!$this->getParam('q')) {
            $this->add('q', $this->defaultQuality);
        }
    }
}
