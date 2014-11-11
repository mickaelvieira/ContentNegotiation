<?php

namespace ContentNegotiation\AcceptHeader\Value;

use ContentNegotiation\AcceptHeader\Value;

/**
 * Class Language
 * @package ContentNegotiation\AcceptHeader\Value
 */
class Language extends Value
{
    /**
     * @var string
     */
    public static $delimiter = "-";

    /**
     * {@inheritdoc}
     */
    public function hasAcceptAllSubTag()
    {
        return $this->hasSubTag(null);
    }
}
