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

use ContentNegotiation\AcceptHeader;

/**
 * Class Values
 * @package ContentNegotiation\AcceptHeader
 */
abstract class Values extends Collection implements AcceptHeader
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
     * @param string $headers
     */
    public function __construct($headers)
    {
        $this->addValues($headers);
        $this->sort();
    }

    /**
     * {@inheritdoc}
     */
    public function hasAcceptAllTag()
    {
        $result = array_filter($this->entities, function ($entity) {
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
        $result = array_filter($this->entities, function ($entity) use ($tag) {
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
        $result = array_filter($this->entities, function ($entity) use ($tag) {
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
        $result = array_filter($this->entities, function ($entity) use ($subTag) {
            /* @var Value $entity */
            return $entity->hasSubTag($subTag);
        });
        return (count($result) > 0);
    }

    /**
     * @param string $value
     * @return bool
     */
    public function hasValue($value)
    {
        $result = array_filter($this->entities, function ($entity) use ($value) {
            /* @var Value $entity */
            return $entity->hasValue($value);
        });
        return (count($result) > 0);
    }

    /**
     * {@inheritdoc}
     */
    public function findFirstMatchingValue(array $values)
    {
        $match = null;
        foreach ($this->entities as $value) {
            /** @var Value $value */
            if (array_search($value->getValue(), $values, true) !== false) {
                $match = $value->getValue();
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
        foreach ($this->entities as $entity) {
            if (!empty($str)) {
                $str .= ",";
            }
            $str .= (string)$entity;
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
            /** @var Value $entity */
            $entity = $this->getEntityInstance($value);
            if ($entity && $entity->getQuality() > 0) {
                $this->add($entity);
            }
        }
        $this->addDefaultValueIfNoneIsDefined();
    }

    /**
     * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
     */
    protected function addDefaultValueIfNoneIsDefined()
    {
        if (count($this->entities) === 0) {
            $valueRange = $this->getEntityInstance($this->defaultValue);
            $this->add($valueRange);
        }
    }

    protected function sort()
    {
        usort($this->entities, [$this, 'sortCallback']);
        $this->entities = array_reverse($this->entities);
    }

    /**
     * @param Value $val1
     * @param Value $val2
     * @return int
     */
    protected function sortCallback(Value $val1, Value $val2)
    {
        $qua1 = $val1->getQuality();
        $qua2 = $val2->getQuality();

        if ($qua1 === $qua2) {
            $result = ($val1->getIndex() < $val2->getIndex()) ? 1 : -1;
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
    protected function getValueClassName()
    {
        return __NAMESPACE__ . "\\Value\\" . $this->entityType;
    }

    /**
     * @param string $value
     * @return \ContentNegotiation\AcceptHeader\Value
     */
    protected function getEntityInstance($value)
    {
        $className = $this->getValueClassName();
        return new $className($value);
    }

    /**
     * @return string
     */
    protected function getValueDelimiter()
    {
        /** @var \ContentNegotiation\AcceptHeader\Value $className */
        $className = $this->getValueClassName();
        return $className::getDelimiter();
    }
}
