<?php

namespace ContentNegotiation\Negotiator;

use ContentNegotiation\Negotiator;
use ContentNegotiation\AcceptHeader;

/**
 * Class Media
 * @package ContentNegotiation\Negotiator
 */
class Media implements Negotiator
{
    /**
     * @var \ContentNegotiation\AcceptHeader;
     */
    private $acceptHeader;

    /**
     * @param AcceptHeader $acceptHeader
     */
    public function __construct(AcceptHeader $acceptHeader)
    {
        $this->acceptHeader = $acceptHeader;
    }

    /**
     * {@inheritdoc}
     */
    public function negotiate(array $supported)
    {
        $value = null;
        if ($value = $this->acceptHeader->findFirstMatchingValue($supported)) {
            return $value;
        }
        if ($value = $this->acceptHeader->findFirstMatchingSubValue($supported)) {
            return $value;
        }
        if ($this->acceptHeader->hasAcceptAllTag() && !empty($supported)) {
            return $supported[0];
        }
        return $value;
    }
}
