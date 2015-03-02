<?php

namespace spec\ContentNegotiation\AcceptHeader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ParamSpec
 * @package spec\ContentNegotiation\AcceptHeader
 */
class ParamSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('param name', 'param value');
        $this->shouldHaveType('ContentNegotiation\AcceptHeader\Param');
    }

    function it_should_return_its_name()
    {
        $this->beConstructedWith('param name', 1);
        $this->getName()->shouldBeEqualTo('param name');
    }

    function it_should_return_its_value()
    {
        $this->beConstructedWith('param name', 1);
        $this->getValue()->shouldBeEqualTo('1');
    }

    function it_should_return_its_string_representation()
    {
        $this->beConstructedWith('param name', 1);
        $this->__toString()->shouldBeEqualTo('param name=1');
    }
}
