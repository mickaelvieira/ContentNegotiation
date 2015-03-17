<?php

namespace spec\ContentNegotiation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class FactorySpec
 * @package spec\ContentNegotiation
 */
class NegotiatorFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ContentNegotiation\NegotiatorFactory');
    }

    function it_should_build_a_language_negotiator()
    {
        $this::makeLanguageNegotiator('')->shouldHaveType('\ContentNegotiation\Negotiator');
    }

    function it_should_build_a_charset_negotiator()
    {
        $this::makeCharsetNegotiator('')->shouldHaveType('\ContentNegotiation\Negotiator');
    }

    function it_should_build_a_media_negotiator()
    {
        $this::makeMediaNegotiator('')->shouldHaveType('\ContentNegotiation\Negotiator');
    }
}
