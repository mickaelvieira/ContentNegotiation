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
     * - fr
     *
     * preferred:
     * - fr-FR
     * - fr-BE
     * - fr-CH
     *
     * returned:
     * - fr-FR
     *
     */
    public static function findFirstPreferredValueMatchingASupportedValueWithAcceptAllSubTag(
        Field $preferred,
        Field $supported
    ) {
        $match = null;
        foreach ($supported as $value) {
            /** @var \ContentNegotiation\Header\Value $value */
            if (!$value->hasAcceptAllTag() && $value->hasAcceptAllSubTag()) {

                $tags = $preferred->getValuesWithTag($value->getTag());

                if (current($tags) !== false) {
                    $match = current($tags);
                    break;
                }
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
