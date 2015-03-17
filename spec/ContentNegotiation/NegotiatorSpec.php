<?php

namespace spec\ContentNegotiation;

use ContentNegotiation\Header\Field;
use ContentNegotiation\Header\FieldTypeFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class NegotiatorSpec
 * @package spec\ContentNegotiation
 */
class NegotiatorSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $preferred = new Field(FieldTypeFactory::makeTypeCharset(), '');
        $this->beConstructedWith(FieldTypeFactory::makeTypeLanguage(), $preferred);
        $this->shouldHaveType('ContentNegotiation\Negotiator');
    }
}
