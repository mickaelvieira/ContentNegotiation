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
 * Class Language
 * @package ContentNegotiation\Header\Value
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