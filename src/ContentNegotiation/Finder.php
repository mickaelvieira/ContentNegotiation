<?php

namespace ContentNegotiation;

use ContentNegotiation\Header\Field;
use ContentNegotiation\Header\ValueRange;

/**
 * Class Finder
 * @package ContentNegotiation
 */
class Finder
{

    /**
     * @param \ContentNegotiation\Header\Field $field
     * @param \ContentNegotiation\Header\Field $supported
     * @return \ContentNegotiation\Header\Value|null
     */
    public static function findFirstMatchingValue(Field $field, Field $supported)
    {
        $match = null;
        foreach ($field as $value) {
            /** @var \ContentNegotiation\Header\Value $value */
            if ($supported->hasExactValue($value->getValue())) {
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
}
