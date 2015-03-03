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

namespace ContentNegotiation\Header\Value;

use ContentNegotiation\Header\Value;

/**
 * Class Charset
 * @package ContentNegotiation\Header\Value
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
