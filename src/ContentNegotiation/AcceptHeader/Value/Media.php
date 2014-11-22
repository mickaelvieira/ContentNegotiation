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

namespace ContentNegotiation\AcceptHeader\Value;

use ContentNegotiation\AcceptHeader\Value;

/**
 * Class Media
 * @package ContentNegotiation\AcceptHeader\Value
 */
class Media extends Value
{
    /**
     * @var string
     */
    public static $delimiter = "/";

    /**
     * @var array
     */
    private $mediaParams = [];

    /**
     * @var array
     */
    private $extParams = [];

    /**
     * @return bool
     */
    public function hasAcceptAllTag()
    {
        return ($this->hasTag('*') && $this->hasSubTag('*'));
    }

    /**
     * {@inheritdoc}
     */
    public function hasAcceptAllSubTag()
    {
        return $this->hasSubTag('*');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $str = $this->getValue();
        $str = $this->joinParameters($str, $this->mediaParams);
        $str = $this->joinQuantity($str);
        $str = $this->joinParameters($str, $this->extParams);

        return $str;
    }

    /**
     * @param $pieces
     */
    protected function addParams($pieces)
    {
        $found = false;
        foreach ($pieces as $piece) {

            $param = explode("=", $piece);

            if (count($param) === 2) {
                if ($param[0] === 'q') {
                    $found = true;
                    $this->setQuality($param[1]);
                } else {
                    if (!$found) {
                        $this->addMediaParam($param[0], $param[1]);
                    } else {
                        $this->addExtParam($param[0], $param[1]);
                    }
                }
            }
        }
    }

    /**
     * @param string $name
     * @param string $value
     */
    private function addMediaParam($name, $value)
    {
        $this->mediaParams[$name] = trim($value);
    }

    /**
     * @param string $name
     * @param string $value
     */
    private function addExtParam($name, $value)
    {
        $this->extParams[$name] = trim($value);
    }

    /**
     * @param string $str
     * @param array $params
     * @return string
     */
    private function joinParameters($str, array $params)
    {
        array_walk(
            $params,
            function (&$item, $key, $equal = "=") {
                $item = $key . $equal . $item;
            }
        );

        if (!empty($str)) {
            $str .= !empty($params) ? ';' . implode(";", $params) : '';
        }

        return $str;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getMediaParamByName($name)
    {
        return (array_key_exists($name, $this->mediaParams)) ? $this->mediaParams[$name] : null;
    }
}
