<?php

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

    /**
     * @param string $headerValue
     * @return array|void
     */
    protected function addValues($headerValue)
    {
        parent::addValues($headerValue);
        $this->addIso88591IfNotPresent();
    }

    /**
     * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
     * If no "*" is present in an Accept-Charset field,
     * then all character sets not explicitly mentioned get a quality value of 0,
     * except for ISO-8859-1, which gets a quality value of 1 if not explicitly mentioned.
     */
    private function addIso88591IfNotPresent()
    {
        if (!$this->hasAcceptAllTag() && !$this->hasTag('iso-8859-1;q=1')) {
            $valueRange = $this->getEntityInstance('iso-8859-1;q=1');
            $this->add($valueRange);
        }
    }
}
