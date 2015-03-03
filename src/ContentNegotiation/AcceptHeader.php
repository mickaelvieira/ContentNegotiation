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

namespace ContentNegotiation;

/**
 * Interface Header
 * @package ContentNegotiation\Header
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
