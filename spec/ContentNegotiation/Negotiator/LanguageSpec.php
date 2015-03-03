<?php

namespace spec\ContentNegotiation\Negotiator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class LanguageSpec
 * @package spec\ContentNegotiation\Negotiator
 */
class LanguageSpec extends ObjectBehavior
{
    /**
     * @param \ContentNegotiation\AcceptHeader\Field\Language $collection
     */
    function let($collection)
    {
        $this->beConstructedWith($collection);
    }

    function it_is_initializable($collection)
    {
        $this->shouldHaveType('ContentNegotiation\Negotiator\Language');
    }

    /**
     * @param \ContentNegotiation\AcceptHeader\Field\Language $collection
     * @param \ContentNegotiation\AcceptHeader\Value\Language $value
     */
    function it_should_return_the_language_when_it_matches_a_supported_language($collection, $value)
    {
        $supported = ['en', 'fr'];
        $collection->findFirstMatchingValue($supported)->willReturn($value);

        $this->negotiate($supported)->shouldReturn($value);
    }

    function it_should_return_the_generic_language($collection)
    {
        $supported = ['en-US', 'fr-BE'];

        $collection->findFirstMatchingValue($supported)->willReturn(null);
        $collection->findFirstMatchingSubValue($supported)->willReturn('en-US');
        $this->negotiate(['en-US', 'fr-BE'])->shouldReturn('en-US');
    }

    function it_should_return_the_1st_supported_when_there_is_no_match_and_the_accept_all_tag_is_present($collection)
    {
        $supported = ['fr-FR', 'es-ES'];

        $collection->findFirstMatchingValue($supported)->willReturn(null);
        $collection->findFirstMatchingSubValue($supported)->willReturn(null);
        $collection->hasAcceptAllTag()->willReturn(true);

        $this->negotiate(['fr-FR', 'es-ES'])->shouldReturn('fr-FR');
    }
}
