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
 * Class ValueRange
 * @package ContentNegotiation\Header
 */
final class ValueRange
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $subValue;

    /**
     * @var string
     */
    private $delimiter = "";

    /**
     * @param string $range
     * @param string $delimiter
     */
    public function __construct($range, $delimiter = "")
    {
        $this->delimiter = $delimiter;
        $this->parseRange($range);
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getSubValue()
    {
        return $this->subValue;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'value'    => $this->value,
            'subValue' => $this->subValue,
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $properties = $this->toArray();
        return implode(
            $this->delimiter,
            array_filter(
                $properties,
                function ($value) {
                    return (!is_null($value) && !empty($value));
                }
            )
        );
    }

    /**
     * @param string $range
     */
    private function parseRange($range)
    {
        $values = $this->getValuesFromString($range);
        if (isset($values[0]) && !empty($values[0])) {
            $this->setValue($values[0]);
        }
        if (isset($values[1]) && !empty($values[1])) {
            $this->setSubValue($values[1]);
        }
    }

    /**
     * @param string $range
     * @return array
     */
    private function getValuesFromString($range)
    {
        if (!empty($this->delimiter)) {
            $values = explode($this->delimiter, $range);
        } else {
            $values = [
                $range
            ];
        }
        return $values;
    }

    /**
     * @param string $value
     */
    private function setValue($value)
    {
        $this->value = trim($value);
    }

    /**
     * @param string $subValue
     */
    private function setSubValue($subValue)
    {
        $this->subValue = trim($subValue);
    }
}
