<?php

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
