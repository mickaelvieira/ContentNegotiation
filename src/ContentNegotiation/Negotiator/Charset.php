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

namespace ContentNegotiation\Negotiator;

use ContentNegotiation\Negotiator;
use ContentNegotiation\AcceptHeader;
use ContentNegotiation\Header\Field;
use ContentNegotiation\Finder;

/**
 * Class Charset
 * @package ContentNegotiation\Negotiator
 */
class Charset implements Negotiator
{
    /**
     * @var \ContentNegotiation\AcceptHeader;
     */
    private $headerField;

    /**
     * @param \ContentNegotiation\Header\Field $headerField
     */
    public function __construct(Field $headerField)
    {
        $this->headerField = $headerField;
    }

    /**
     * {@inheritdoc}
     */
    public function negotiate(array $supported)
    {
        $value = null;
        $supported = new Field("charset", implode(";", $supported));
        if ($value = Finder::findFirstPreferredValueMatchingASupportedValue(
            $this->headerField,
            $supported
        )) {
            return $value;
        }
        if ($value = Finder::findFirstSupportedValueMatchingAPreferredValueWithAcceptAllSubTag(
            $this->headerField,
            $supported
        )) {
            return $value;
        }
        if ($value = Finder::findFirstSupportedValueWhenPreferredValueHasAcceptAllTag(
            $this->headerField,
            $supported
        )) {
            return $value;
        }
        return $value;
    }
}
