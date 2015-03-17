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
 * Class Field
 * @package ContentNegotiation\Header
 */
final class Field implements \IteratorAggregate, \Countable
{
    /**
     * @var \ContentNegotiation\Header\FieldType
     */
    private $type;

    /**
     * @var \ContentNegotiation\Header\Value[]
     */
    private $values = [];

    /**
     * @param \ContentNegotiation\Header\FieldType $type
     * @param string|array                         $headerValue
     */
    public function __construct(FieldType $type, $headerValue)
    {
        $this->type = $type;

        $values = (!is_array($headerValue)) ? $this->splitHeaderStringValues($headerValue) : $headerValue;

        $this->addValues($values);
        $this->sort();
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->values);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->values);
    }

    /**
     * @return bool
     */
    public function hasAcceptAllTag()
    {
        $result = array_filter($this->values, function (Value $value) {
            return $value->hasAcceptAllTag();
        });
        return (count($result) > 0);
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function hasAcceptAllSubTag($tag)
    {
        $result = array_filter($this->values, function (Value $value) use ($tag) {
            return $value->hasTag($tag) && $value->hasAcceptAllSubTag();
        });
        return (count($result) > 0);
    }

    /**
     * @param string $val
     *
     * @return bool
     */
    public function hasExactValue($val)
    {
        $result = array_filter($this->values, function (Value $value) use ($val) {
            return $value->isEqual($val);
        });
        return (count($result) > 0);
    }

    /**
     * @param string $tag
     *
     * @return \ContentNegotiation\Header\Value[]
     */
    public function getValuesWithTag($tag)
    {
        $result = array_filter($this->values, function (Value $value) use ($tag) {
            return $value->hasTag($tag);
        });
        return array_values($result);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(",", array_map(function (Value $value) {
            return (string)$value;
        }, $this->values));
    }

    /**
     * @param array $values
     */
    private function addValues(array $values)
    {
        foreach ($values as $value) {
            $entity = new Value($this->type, $value, $this->count());
            if ($entity->getQuality() > 0) {
                array_push($this->values, $entity);
            }
        }
        $this->addDefaultValueIfNoneIsDefined();
    }

    /**
     * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
     */
    private function addDefaultValueIfNoneIsDefined()
    {
        if ($this->count() === 0) {
            $value = new Value($this->type, $this->type->getDefaultValue(), $this->count());
            array_push($this->values, $value);
        }
    }

    /**
     * @param $headerValue
     *
     * @return array
     */
    private function splitHeaderStringValues($headerValue)
    {
        return (is_string($headerValue) && !empty($headerValue)) ? explode(",", $headerValue) : [];
    }

    private function sort()
    {
        usort($this->values, function (Value $val1, Value $val2) {

            $qua1 = $val1->getQuality();
            $qua2 = $val2->getQuality();

            if ($qua1 === $qua2) {

                $count1 = $val1->countParams();
                $count2 = $val2->countParams();

                if ($count1 === $count2) {
                    $result = ($val1->getPosition() < $val2->getPosition()) ? 1 : -1;
                } elseif ($count1 < $count2) {
                    $result = -1;
                } else {
                    $result = 1;
                }
            } elseif ($qua1 < $qua2) {
                $result = -1;
            } else {
                $result = 1;
            }
            return $result;
        });

        $this->values = array_reverse($this->values);
    }
}
