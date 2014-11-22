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

namespace ContentNegotiation\AcceptHeader\Values;

use ContentNegotiation\AcceptHeader\Values;

/**
 * Class Charset
 * @package ContentNegotiation\AcceptHeader\JsonCollection
 */
class Charset extends Values
{
    /**
     * {@inheritdoc}
     */
    protected $defaultValue = '*';

    /**
     * {@inheritdoc}
     */
    protected $entityType = 'Charset';

    /**
     * {@inheritdoc}
     */
    public function hasAcceptAllSubTag($tag)
    {
        return false;
    }
}
