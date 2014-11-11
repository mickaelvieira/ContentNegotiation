<?php

namespace spec\ContentNegotiation\Negotiator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class CharsetSpec
 * @package spec\ContentNegotiation\Negotiator
 */
class CharsetSpec extends ObjectBehavior
{
    /**
     * @param \ContentNegotiation\AcceptHeader\Values\Charset $collection
     */
    function let($collection)
    {
        $this->beConstructedWith($collection);
    }

    function it_is_initializable($collection)
    {
        $this->shouldHaveType('ContentNegotiation\Negotiator\Charset');
    }

    function it_should_return_the_charset_when_it_matches_a_supported_charset($collection)
    {
        $supported = ['iso-8859-5', 'iso-8859-1', 'unicode-1-1'];

        $collection->findFirstMatchingValue($supported)->willReturn('unicode-1-1');

        $this->negotiate($supported)->shouldReturn('unicode-1-1');
    }

    function it_should_return_null_when_it_does_not_match_any_and_the_accept_tag_is_not_present($collection)
    {
        $supported = ['iso-8859-5', 'iso-8859-1', 'unicode-1-1'];

        $collection->findFirstMatchingValue($supported)->willReturn(null);
        $collection->findFirstMatchingSubValue($supported)->willReturn(null);
        $collection->hasAcceptAllTag()->willReturn(false);

        $this->negotiate($supported)->shouldReturn(null);
    }

    function it_should_return_the_1st_supported_when_it_does_not_match_any_but_the_accept_all_tag_is_present($collection)
    {
        $supported = ['utf-8', 'utf-7', 'utf-16'];

        $collection->findFirstMatchingValue($supported)->willReturn(null);
        $collection->findFirstMatchingSubValue($supported)->willReturn(null);
        $collection->hasAcceptAllTag()->willReturn(true);

        $this->negotiate($supported)->shouldReturn('utf-8');
    }
}
