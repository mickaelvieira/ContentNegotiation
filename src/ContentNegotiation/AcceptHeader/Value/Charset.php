<?php

namespace ContentNegotiation\AcceptHeader\Value;

use ContentNegotiation\AcceptHeader\Value;

/**
 * Class Charset
 * @package ContentNegotiation\AcceptHeader\Value
 */
class Charset extends Value
{
    /**
     * {@inheritdoc}
     */
    public function hasAcceptAllSubTag()
    {
        return false;
    }
}
