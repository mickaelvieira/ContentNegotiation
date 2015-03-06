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

use ContentNegotiation\Header\Value;

/**
 * Class Field
 * @package ContentNegotiation\Header
 */
class Field implements \IteratorAggregate, \Countable
{
    /**
     * @var string
     */
    protected $defaultValue;

    /**
     * @var string
     */
    protected $entityType;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var string
     */
    private $type;

    /**
     * @param $type
     * @param $headers
     */
    public function __construct($type, $headers)
    {
        $this->isValidFieldType($type);

        $this->type = $type;
        $this->addValues($headers);
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
     * @param string $tag
     * @return bool
     */
    public function hasTag($tag)
    {
        $result = array_filter($this->values, function ($entity) use ($tag) {
            /* @var Value $entity */
            return $entity->hasTag($tag);
        });
        return (count($result) > 0);
    }

    /**
     * @param string $subTag
     * @return bool
     */
    public function hasSubTag($subTag)
    {
        $result = array_filter($this->values, function ($entity) use ($subTag) {
            /* @var Value $entity */
            return $entity->hasSubTag($subTag);
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
     * {@inheritdoc}
     */
    public function findFirstMatchingValue(array $values)
    {
        $match = null;
        foreach ($this->values as $value) {
            /** @var Value $value */
            if (array_search($value->getValue(), $values, true) !== false) {
                $match = $value;
                break;
            }
        }
        return $match;
    }

    /**
     * @param array $values
     * @return null
     */
    public function findFirstMatchingSubValue(array $values)
    {
        $match = null;
        foreach ($values as $value) {
            $range = new ValueRange($value, $this->getValueDelimiter());
            if ($this->hasTag($range->getValue()) && $this->hasAcceptAllSubTag($range->getValue())) {
                $match = $value;
                break;
            }
        }
        return $match;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $str = "";
        foreach ($this->values as $value) {
            if (!empty($str)) {
                $str .= ",";
            }
            $str .= (string)$value;
        }
        return $str;
    }

    /**
     * @param string $headerValue
     * @return array
     */
    protected function addValues($headerValue)
    {
        $values = (is_string($headerValue) && !empty($headerValue)) ? explode(",", $headerValue) : [];

        foreach ($values as $value) {

            $entity = new Value(
                $value,
                $this->count(),
                $this->getValueDelimiter()
            );

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

            $value = new Value(
                $this->getDefaultValue(),
                $this->count(),
                $this->getValueDelimiter()
            );
            array_push($this->values, $value);
        }
    }

    /**
     * @return string
     */
    private function getDefaultValue()
    {
        return ($this->type === FieldType::MEDIA_TYPE) ? '*/*' : '*';
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

    /**
     * @return string
     */
    private function getValueDelimiter()
    {
        /** @var Value $className */
        $delimiter = "";
        if ($this->type === FieldType::LANGUAGE_TYPE) {
            $delimiter = '-';
        } elseif ($this->type === FieldType::MEDIA_TYPE) {
            $delimiter = '/';
        }

        return $delimiter;
    }

    /**
     * @param $type
     * @return bool
     */
    private function isValidFieldType($type)
    {
        if (
            $type !== FieldType::LANGUAGE_TYPE &&
            $type !== FieldType::CHARSET_TYPE &&
            $type !== FieldType::MEDIA_TYPE
        ) {

            throw new \InvalidArgumentException(sprintf(
                "Invalid argument, expected %s, %s or %s",
                FieldType::LANGUAGE_TYPE,
                FieldType::CHARSET_TYPE,
                FieldType::MEDIA_TYPE
            ));
        }

        return true;
    }
}
