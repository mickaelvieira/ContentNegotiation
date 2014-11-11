<?php

namespace ContentNegotiation\AcceptHeader\Values;

use ContentNegotiation\AcceptHeader\Values;

/**
 * Class Language
 * @package ContentNegotiation\AcceptHeader\JsonCollection
 */
class Language extends Values
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
