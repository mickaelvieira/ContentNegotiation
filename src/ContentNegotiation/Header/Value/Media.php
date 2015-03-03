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

use ContentNegotiation\Header\Param;
use ContentNegotiation\Header\Value;

/**
 * Class Media
 * @package ContentNegotiation\Header\Value
 */
class Media extends Value
{
    /**
     * @var string
     */
    public static $delimiter = "/";


    /**
     * @return bool
     */
    public function hasAcceptAllTag()
    {
        return ($this->hasTag('*') && $this->hasSubTag('*'));
    }

    /**
     * {@inheritdoc}
     */
    public function hasAcceptAllSubTag()
    {
        return $this->hasSubTag('*');
    }
}
