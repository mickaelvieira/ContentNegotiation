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

namespace ContentNegotiation\Header\Field;

use ContentNegotiation\Header\Field;

/**
 * Class Language
 * @package ContentNegotiation\Header\JsonCollection
 */
class Language extends Field
{
    /**
     * {@inheritdoc}
     */
    protected $defaultValue = '*';

    /**
     * {@inheritdoc}
     */
    protected $entityType = 'Language';
}