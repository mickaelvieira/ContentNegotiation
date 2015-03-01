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
 * Class JsonCollection
 * @package ContentNegotiation\AcceptHeader
 */
class Collection implements \IteratorAggregate
{
    /**
     * @var array
     */
    protected $entities = [];

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->entities);
    }
}
