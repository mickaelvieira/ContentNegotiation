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

use ContentNegotiation\Header\Value;
use ContentNegotiation\Header\Field;

/**
 * Class Media
 * @package ContentNegotiation\Header\JsonCollection
 */
class Media extends Field
{
    /**
     * {@inheritdoc}
     */
    protected $defaultValue = '*/*;q=1';

    /**
     * {@inheritdoc}
     */
    protected $entityType = 'Media';

    /**
     * {@inheritdoc}
     */
    protected function sortCallback(Value $val1, Value $val2)
    {
        $qua1 = $val1->getQuality();
        $qua2 = $val2->getQuality();

        if ($qua1 === $qua2) {

            $count1 = $val1->countParams();
            $count2 = $val2->countParams();

            if ($count1 === $count2) {
                $result = ($val1->getPosition() < $val2->getPosition()) ? 1 : -1; // <- louche
            } elseif ($count1 < $count2) {
                $result = -1;
            } else {
                $result = 1;
            }
        } elseif ($qua1 < $qua2) {
            $result = -1;
        } else {
            $result = 1;
        }
        return $result;
    }
}
