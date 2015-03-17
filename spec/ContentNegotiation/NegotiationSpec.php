<?php

namespace spec\ContentNegotiation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class NegotiationSpec
 * @package spec\ContentNegotiation
 */
class NegotiationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith([]);
        $this->shouldHaveType('ContentNegotiation\Negotiation');
    }

    function it_should_return_the_first_supported_media_when_there_is_no_preferred_media()
    {
        $supported = ['application/json', 'application/xml', 'application/atom+xml'];

        $this->beConstructedWith([]);
        $this->getMedia($supported)->shouldHaveType('\ContentNegotiation\Header\Value');
        $this->getMedia($supported)->getValue()->shouldBeEqualTo('application/json');
    }

    function it_should_return_null_when_there_is_no_preferred_media_supported()
    {
        $supported = ['text/html', 'text/plain'];

        $this->beConstructedWith([
            'Accept' => 'audio/*; q=0.2, audio/basic'
        ]);
        $this->getMedia($supported)->shouldBeNull();
    }

    function it_should_return_the_first_preferred_media_supported()
    {
        $supported = ['text/html', 'text/plain'];

        $this->beConstructedWith([
            'Accept' => 'text/*, text/plain, text/plain;format=flowed, */*'
        ]);
        $this->getMedia($supported)->shouldHaveType('\ContentNegotiation\Header\Value');
        $this->getMedia($supported)->getValue()->shouldBeEqualTo('text/plain');
        $this->getMedia($supported)->getParam('format')->shouldHaveType('\ContentNegotiation\Header\Param');
    }

    function it_should_return_the_first_supported_media_matching_a_subtype()
    {
        $supported = 'text/html, text/xml';

        $this->beConstructedWith([
            'Accept' => 'text/*, text/plain, text/plain;format=flowed, */*'
        ]);
        $this->getMedia($supported)->shouldHaveType('\ContentNegotiation\Header\Value');
        $this->getMedia($supported)->getValue()->shouldBeEqualTo('text/html');
    }

    function it_should_return_the_first_supported_media_when_all_are_accepted()
    {
        $supported = ['text/html', 'text/plain'];

        $this->beConstructedWith([
            'Accept' => 'application/json, application/xml, */*'
        ]);
        $this->getMedia($supported)->shouldHaveType('\ContentNegotiation\Header\Value');
        $this->getMedia($supported)->getValue()->shouldBeEqualTo('text/html');
    }

    function it_should_return_the_first_supported_language_when_there_is_no_preferred_language()
    {
        $supported = 'da, en-gb;q=0.8, en;q=0.7';

        $this->beConstructedWith([]);
        $this->getLanguage($supported)->shouldHaveType('\ContentNegotiation\Header\Value');
        $this->getLanguage($supported)->getValue()->shouldBeEqualTo('da');
    }

    function it_should_return_null_when_there_is_no_preferred_language_supported()
    {
        $supported = ['fr', 'en'];

        $this->beConstructedWith([
            'Accept-Language' => 'lg-lug, lg;q=0.7'
        ]);
        $this->getLanguage($supported)->shouldBeNull();
    }

    function it_should_return_the_first_preferred_language_supported()
    {
        $supported = ['fr', 'en'];

        $this->beConstructedWith([
            'Accept-Language' => 'fr-FR, fr;q=0.8, en;q=0.7'
        ]);
        $this->getLanguage($supported)->shouldHaveType('\ContentNegotiation\Header\Value');
        $this->getLanguage($supported)->getValue()->shouldBeEqualTo('fr');
    }

    function it_should_return_the_first_supported_language_matching_a_subtype()
    {
        $supported = 'en-GB, en-US';

        $this->beConstructedWith([
            'Accept-Language' => 'fr-FR, fr;q=0.8, en;q=0.7'
        ]);
        $this->getLanguage($supported)->shouldHaveType('\ContentNegotiation\Header\Value');
        $this->getLanguage($supported)->getValue()->shouldBeEqualTo('en-GB');
    }

    function it_should_return_the_first_supported_language_when_all_are_accepted()
    {
        $supported = 'en-GB, en-US';

        $this->beConstructedWith([
            'Accept-Language' => 'it, *'
        ]);
        $this->getLanguage($supported)->shouldHaveType('\ContentNegotiation\Header\Value');
        $this->getLanguage($supported)->getValue()->shouldBeEqualTo('en-GB');
    }

    function it_should_return_the_first_supported_charset_when_there_is_no_preferred_charset()
    {
        $supported = 'iso-8859-5, unicode-1-1;q=0.8';

        $this->beConstructedWith([]);
        $this->getCharset($supported)->shouldHaveType('\ContentNegotiation\Header\Value');
        $this->getCharset($supported)->getValue()->shouldBeEqualTo('iso-8859-5');
    }

    function it_should_return_null_when_there_is_no_preferred_charset_supported()
    {
        $supported = 'iso-8859-5, unicode-1-1;q=0.8';

        $this->beConstructedWith([
            'Accept-Charset' => 'utf-8'
        ]);
        $this->getCharset($supported)->shouldBeNull();
    }


    function it_should_return_the_first_preferred_charset_supported()
    {
        $supported = 'iso-8859-5, unicode-1-1, utf-8';

        $this->beConstructedWith([
            'Accept-Charset' => 'utf-8'
        ]);
        $this->getCharset($supported)->shouldHaveType('\ContentNegotiation\Header\Value');
        $this->getCharset($supported)->getValue()->shouldBeEqualTo('utf-8');
    }

    function it_should_return_the_first_supported_charset_when_all_are_accepted()
    {
        $supported = 'iso-8859-5, unicode-1-1;q=0.8';

        $this->beConstructedWith([
            'Accept-Charset' => 'utf-8, *'
        ]);
        $this->getCharset($supported)->shouldHaveType('\ContentNegotiation\Header\Value');
        $this->getCharset($supported)->getValue()->shouldBeEqualTo('iso-8859-5');
    }
}
