<?php

namespace spec\ContentNegotiation;

use ContentNegotiation\Header\FieldTypeFactory;
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
        $this::make(FieldTypeFactory::makeTypeLanguage(), [])
            ->shouldHaveType('\ContentNegotiation\Negotiator');
    }

    function it_should_build_a_charset_negotiator()
    {
        $this::make(FieldTypeFactory::makeTypeCharset(), [])
            ->shouldHaveType('\ContentNegotiation\Negotiator');
    }

    function it_should_build_a_media_negotiator()
    {
        $this::make(FieldTypeFactory::makeTypeMedia(), [])
            ->shouldHaveType('\ContentNegotiation\Negotiator');
    }
}
