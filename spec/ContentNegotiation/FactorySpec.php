<?php

namespace spec\ContentNegotiation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class FactorySpec
 * @package spec\ContentNegotiation
 */
class FactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ContentNegotiation\Factory');
    }

    function it_should_build_a_language_negotiator()
    {
        $this::build('language', [])->shouldHaveType('\ContentNegotiation\Negotiator\Language');
        $this::build('language', [])->shouldHaveType('\ContentNegotiation\Negotiator');
    }

    function it_should_build_a_charset_negotiator()
    {
        $this::build('charset', [])->shouldHaveType('\ContentNegotiation\Negotiator\Charset');
        $this::build('charset', [])->shouldHaveType('\ContentNegotiation\Negotiator');
    }

    function it_should_build_a_media_negotiator()
    {
        $this::build('media', [])->shouldHaveType('\ContentNegotiation\Negotiator\Media');
        $this::build('media', [])->shouldHaveType('\ContentNegotiation\Negotiator');
    }
}
