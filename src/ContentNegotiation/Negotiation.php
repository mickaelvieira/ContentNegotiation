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
 * Class Negotiation
 * @package ContentNegotiation
 * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec12
 */
interface Negotiation
{
    /**
     * @param array $supported
     * @return null|string
     */
    public function getMedia(array $supported);

    /**
     * @param array $supported
     * @return null|string
     */
    public function getLanguage(array $supported);

    /**
     * @param array $supported
     * @return null|string
     */
    public function getCharset(array $supported);
}
