<?php

namespace spec\ContentNegotiation\Header\Value;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class CharsetSpec
 * @package spec\ContentNegotiation\Header\Value
 */
class CharsetSpec extends ObjectBehavior
{
    /**
     * *
     * iso-8859-5
     * unicode-1-1;q=0.8
     */

    /*function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType('ContentNegotiation\Header\Value\Charset');
    }

    function it_should_return_an_empty_string_when_input_is_empty()
    {
        $this->beConstructedWith('');
        $this->__toString()->shouldBeEqualTo('');
    }

    function it_should_return_the_charset_when_it_is_present_in_the_header_string()
    {
        $this->beConstructedWith('iso-8859-5');
        $this->getValue()->shouldBeEqualTo('iso-8859-5');
    }

    function it_should_have_a_quality_equal_to_one_when_it_is_not_present_in_the_header_string()
    {
        $this->beConstructedWith('iso-8859-5');
        $this->getQuality()->shouldBeEqualTo(1.0);
    }

    function it_should_return_the_quality_when_it_is_present_in_the_header_string()
    {
        $this->beConstructedWith('unicode-1-1;q=0.8');
        $this->getQuality()->shouldBeEqualTo(0.8);
    }

    function it_should_be_aware_of_having_the_match_all_tag_when_it_is_present_in_the_header_string()
    {
        $this->beConstructedWith('*');
        $this->shouldHaveAcceptAllTag();
    }

    function it_should_be_aware_of_having_a_value_range()
    {
        $this->beConstructedWith('unicode-1-1;q=0.8');
        $this->shouldBeEqual('unicode-1-1');
    }

    function it_should_have_the_quality_equal_to_one_it_has_the_match_all_tag()
    {
        $this->beConstructedWith('*');
        $this->getQuality()->shouldBeEqualTo(1.0);
    }*/
}
