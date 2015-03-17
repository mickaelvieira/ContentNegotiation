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
use ContentNegotiation\Header\FieldType;

/**
 * Class Negotiator
 * @package ContentNegotiation
 */
final class Negotiator
{
    /**
     * @var \ContentNegotiation\Header\FieldType
     */
    private $type;

    /**
     * @var \ContentNegotiation\Header\Field;
     */
    private $preferred;

    /**
     * @param \ContentNegotiation\Header\FieldType  $type
     * @param \ContentNegotiation\Header\Field $preferred
     */
    public function __construct(FieldType $type, Field $preferred)
    {
        $this->type = $type;
        $this->preferred = $preferred;
    }

    /**
     * @param array|string $supported
     * @return \ContentNegotiation\Header\Value|null
     */
    public function negotiate($supported)
    {
        $value = null;
        $supported = new Field($this->type, $supported);

        if ($value = Finder::findFirstPreferredValueMatchingASupportedValue(
            $this->preferred,
            $supported
        )) {
            return $value;
        }
        if ($value = Finder::findFirstSupportedValueMatchingAPreferredValueWithAcceptAllSubTag(
            $this->preferred,
            $supported
        )) {
            return $value;
        }
        if ($value = Finder::findFirstSupportedValueWhenPreferredValueHasAcceptAllTag(
            $this->preferred,
            $supported
        )) {
            return $value;
        }
        return $value;
    }
}
