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
class Field implements \IteratorAggregate, \Countable
{
    /**
     * @var FieldType
     */
    private $type;

    /**
     * @var array
     */
    private $values = [];

    /**
     * @param $type
     * @param $headerValue
     */
    public function __construct(FieldType $type, $headerValue)
    {
        $this->type = $type;
        $this->addValues($headerValue);
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
     * {@inheritdoc}
     */
    public function hasAcceptAllTag()
    {
        $result = array_filter($this->values, function ($entity) {
            /* @var Value $entity */
            return $entity->hasAcceptAllTag();
        });
        return (count($result) > 0);
    }

    /**
     * {@inheritdoc}
     */
    public function hasAcceptAllSubTag($tag)
    {
        $result = array_filter($this->values, function ($entity) use ($tag) {
            /* @var Value $entity */
            return $entity->hasTag($tag) && $entity->hasAcceptAllSubTag();
        });
        return (count($result) > 0);
    }

    /**
     * @param string $value
     * @return bool
     */
    public function hasExactValue($value)
    {
        $result = array_filter($this->values, function ($entity) use ($value) {
            /* @var Value $entity */
            return $entity->isEqual($value);
        });
        return (count($result) > 0);
    }

    /**
     * @param $tag
     * @return array
     */
    public function getValuesWithTag($tag)
    {
        $result = array_filter($this->values, function ($entity) use ($tag) {
            /* @var Value $entity */
            return $entity->hasTag($tag);
        });
        return array_values($result);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(",", array_map(function ($item) {
            return (string)$item;
        }, $this->values));
    }

    /**
     * @param string $headerValue
     * @return array
     */
    protected function addValues($headerValue)
    {
        $values = (is_string($headerValue) && !empty($headerValue)) ? explode(",", $headerValue) : [];

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

    private function sort()
    {
        usort($this->values, [$this, 'sortCallback']);
        $this->values = array_reverse($this->values);
    }

    /**
     * @param Value $val1
     * @param Value $val2
     * @return int
     */
    private function sortCallback(Value $val1, Value $val2)
    {
        /*$qua1 = $val1->getQuality();
        $qua2 = $val2->getQuality();

        if ($qua1 === $qua2) {
            $result = ($val1->getPosition() < $val2->getPosition()) ? 1 : -1;
        } elseif ($qua1 < $qua2) {
            $result = -1;
        } else {
            $result = 1;
        }
        return $result;*/
        $qua1 = $val1->getQuality();
        $qua2 = $val2->getQuality();

        if ($qua1 === $qua2) {

            $count1 = $val1->countParams();
            $count2 = $val2->countParams();

            if ($count1 === $count2) {
                $result = ($val1->getPosition() < $val2->getPosition()) ? 1 : -1; // <- louche
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
    }
}
