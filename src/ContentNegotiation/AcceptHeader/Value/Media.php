<?php

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
     * @param string $key
     * @param string $value
     */
    private function addMediaParam($key, $value)
    {
        $this->mediaParams[$key] = trim($value);
    }

    /**
     * @param string $key
     * @param string $value
     */
    private function addExtParam($key, $value)
    {
        $this->extParams[$key] = trim($value);
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
}
