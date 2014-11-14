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

namespace ContentNegotiation\AcceptHeader;

/**
 * Class Value
 * @package ContentNegotiation\AcceptHeader
 */
class Entity
{
    /**
     * @var int
     */
    protected $index = 0;

    /**
     * @param int $index
     */
    public function setIndex($index)
    {
        $this->index = (int)$index;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }
}
