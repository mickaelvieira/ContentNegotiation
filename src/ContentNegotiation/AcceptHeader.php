<?php

namespace ContentNegotiation;

/**
 * Interface AcceptHeader
 * @package ContentNegotiation\AcceptHeader
 */
interface AcceptHeader
{
    /**
     * @return bool
     */
    public function hasAcceptAllTag();

    /**
     * @param array $values
     * @return null|string
     */
    public function findFirstMatchingValue(array $values);

    /**
     * @param array $values
     * @return null|string
     */
    public function findFirstMatchingSubValue(array $values);
}
