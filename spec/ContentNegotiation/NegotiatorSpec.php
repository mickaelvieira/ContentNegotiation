<?php

namespace spec\ContentNegotiation;

use ContentNegotiation\ContentTypeFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NegotiatorSpec extends ObjectBehavior
{

    /**
     * @param \ContentNegotiation\Header\Field $preferred
     */
    function it_is_initializable($preferred)
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeLanguage(), $preferred);
        $this->shouldHaveType('ContentNegotiation\Negotiator');
    }
}
