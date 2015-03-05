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

use ContentNegotiation\Finder;
use ContentNegotiation\Header\Field;
use ContentNegotiation\Negotiator;
use ContentNegotiation\AcceptHeader;

/**
 * Class Language
 * @package ContentNegotiation\Negotiator
 */
class Language implements Negotiator
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
        if ($value = $this->headerField->findFirstMatchingValue($supported)) {
            return $value;
        }
        if ($value = $this->headerField->findFirstMatchingSubValue($supported)) {
            return $value;
        }
        if ($this->headerField->hasAcceptAllTag() && !empty($supported)) {
            return $supported[0];
        }
        return $value;
    }
}
