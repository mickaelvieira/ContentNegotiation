<?php

namespace spec\ContentNegotiation\AcceptHeader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ValueRangeSpec
 * @package spec\ContentNegotiation\AcceptHeader
 */
class ValueRangeSpec extends ObjectBehavior
{
    function it_should_alter_values_when_no_delimiter_is_specified()
    {
        $this->beConstructedWith("test");
        $this->__toString()->shouldBeEqualTo('test');
    }

    function it_should_alter_values_when_no_delimiter_is_specified_and_a_slash_is_present()
    {
        $this->beConstructedWith("bar/*");
        $this->__toString()->shouldBeEqualTo('bar/*');
    }

    function it_should_alter_values_when_no_delimiter_is_specified_and_a_dash_is_present()
    {
        $this->beConstructedWith("bar-foo");
        $this->__toString()->shouldBeEqualTo('bar-foo');
    }

    function it_should_be_able_to_split_the_provided_string_when_delimiter_is_specified()
    {
        $this->beConstructedWith("bar-foo", "-");
        $this->getValue()->shouldBeEqualTo('bar');
        $this->getSubValue()->shouldBeEqualTo('foo');
        $this->__toString()->shouldBeEqualTo('bar-foo');
    }

    function it_should_be_able_to_split_the_provided_string_when_delimiter_is_specified_and_a_value_is_missing()
    {
        $this->beConstructedWith("bar/", "/");
        $this->getValue()->shouldBeEqualTo('bar');
        $this->getSubValue()->shouldBeEqualTo(null);
        $this->__toString()->shouldBeEqualTo('bar');
    }
}
