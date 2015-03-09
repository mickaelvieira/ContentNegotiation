<?php

namespace spec\ContentNegotiation\Header\Value;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class LanguageSpec
 * @package spec\ContentNegotiation\Header\Value
 */
class LanguageSpec extends ObjectBehavior
{
    /**
     * *
     * da
     * en-gb;q=0.8
     * en;q=0.7
     */

    /*function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType('ContentNegotiation\Header\Value\Language');
    }

    function it_should_return_an_empty_string_when_input_is_empty()
    {
        $this->beConstructedWith('');
        $this->__toString()->shouldBeEqualTo('');
    }

    function it_should_return_the_language_range_when_it_is_present_in_the_header_string()
    {
        $this->beConstructedWith('da');
        $this->getValue()->shouldBeEqualTo('da');
    }

    function it_should_have_the_quality_equal_to_one_when_it_is_not_present_in_the_header_string()
    {
        $this->beConstructedWith('en-gb');
        $this->getQuality()->shouldBeEqualTo(1.0);
    }

    function it_should_return_the_quality_when_it_is_present_in_the_header_string()
    {
        $this->beConstructedWith('en-gb; q=0.4');
        $this->getQuality()->shouldBeEqualTo(0.4);
    }

    function it_should_be_aware_of_having_the_match_all_tag_when_it_is_present_in_the_header_string()
    {
        $this->beConstructedWith('*; q=0.3');
        $this->shouldHaveAcceptAllTag();
    }

    function it_should_be_aware_of_having_the_match_all_sub_tag()
    {
        $this->beConstructedWith('fr');
        $this->shouldHaveAcceptAllSubTag();
    }

    function it_should_be_aware_of_having_a_tag()
    {
        $this->beConstructedWith('fr-be');
        $this->shouldHaveTag('fr');
    }

    function it_should_be_aware_of_having_a_sub_tag()
    {
        $this->beConstructedWith('fr-be');
        $this->shouldHaveSubTag('be');
    }

    function it_should_be_aware_of_having_a_value_range()
    {
        $this->beConstructedWith('fr-be');
        $this->shouldBeEqual('fr-be');
    }*/
}
