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
use ContentNegotiation\ContentType;

/**
 * Class Negotiator
 * @package ContentNegotiation
 * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
 */
final class Negotiator
{
    /**
     * @var \ContentNegotiation\AcceptHeader;
     */
    private $headerField;

    /**
     * @var \ContentNegotiation\ContentType
     */
    private $contentType;

    /**
     * @param \ContentNegotiation\ContentType  $contentType
     * @param \ContentNegotiation\Header\Field $preferred
     */
    public function __construct(ContentType $contentType, Field $preferred)
    {
        $this->contentType = $contentType;
        $this->headerField = $preferred;
    }

    /**
     * {@inheritdoc}
     */
    public function negotiate(array $supported)
    {
        $value = null;
        $supported = new Field($this->contentType, implode(";", $supported));
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
