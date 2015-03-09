<?php

namespace ContentNegotiation;

use ContentNegotiation\Header\Field;

/**
 * Class Finder
 * @package ContentNegotiation
 */
class Finder
{
    /**
     * @param \ContentNegotiation\Header\Field $preferred
     * @param \ContentNegotiation\Header\Field $supported
     * @return \ContentNegotiation\Header\Value|null

     * preferred:
     * - application/json
     * - application/xml
     * - application/atom+xml
     *
     * supported:
     * - application/xml
     * - application/atom+xml
     *
     * returned:
     * - application/xml
     *
     */
    public static function findFirstPreferredValueMatchingASupportedValue(
        Field $preferred,
        Field $supported
    ) {
        $match = null;
        foreach ($preferred as $value) {
            /** @var \ContentNegotiation\Header\Value $value */
            if ($supported->hasExactValue($value->getValue())) {
                $match = $value;
                break;
            }
        }
        return $match;
    }

    /**
     * @param \ContentNegotiation\Header\Field $preferred
     * @param \ContentNegotiation\Header\Field $supported
     * @return \ContentNegotiation\Header\Value|null
     *
     * supported:
     * - application/json
     * - application/xml
     * - application/atom+xml
     *
     * preferred:
     * - application/*
     *
     * returned:
     * - application/json
     *
     */
    public static function findFirstSupportedValueMatchingAPreferredValueWithAcceptAllSubTag(
        Field $preferred,
        Field $supported
    ) {
        $match = null;
        foreach ($supported as $value) {
            /** @var \ContentNegotiation\Header\Value $value */
            if (!$value->hasAcceptAllTag() && $preferred->hasAcceptAllSubTag($value->getTag())) {
                $match = $value;
                break;
            }
        }
        return $match;
    }

    /**
     * @param \ContentNegotiation\Header\Field $preferred
     * @param \ContentNegotiation\Header\Field $supported
     * @return \ContentNegotiation\Header\Value|null
     *
     * supported:
     * - application/json
     * - application/xml
     * - application/atom+xml
     *
     * preferred:
     * - *
     *
     * returned:
     * - application/json
     *
     */
    public static function findFirstSupportedValueWhenPreferredValueHasAcceptAllTag(
        Field $preferred,
        Field $supported
    ) {
        $match = null;
        if ($preferred->hasAcceptAllTag()) {
            if ($supported->count() > 0) {
                $values = $supported->getIterator();
                $match  = $values[0];
            }
        }
        return $match;
    }
}
