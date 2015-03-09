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
 * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
 */
final class Negotiator
{
    /**
     * @var \ContentNegotiation\ContentType
     */
    private $contentType;

    /**
     * @var \ContentNegotiation\Header\Field;
     */
    private $preferred;

    /**
     * @param \ContentNegotiation\Header\FieldType  $contentType
     * @param \ContentNegotiation\Header\Field $preferred
     */
    public function __construct(FieldType $contentType, Field $preferred)
    {
        $this->contentType = $contentType;
        $this->preferred   = $preferred;
    }

    /**
     * {@inheritdoc}
     */
    public function negotiate(array $supported)
    {
        $value = null;
        $supported = new Field($this->contentType, implode(";", $supported));
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
