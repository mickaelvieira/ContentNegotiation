<?php

namespace spec\ContentNegotiation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class TypeFactorySpec
 * @package spec\ContentNegotiation
 */
class ContentTypeFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ContentNegotiation\ContentTypeFactory');
    }

    function it_should_make_a_media_type()
    {
        $this::makeTypeMedia()->shouldHaveType('ContentNegotiation\ContentType');
        $this::makeTypeMedia()->shouldBeMediaType();
        $this::makeTypeMedia()->getDefaultValue()->shouldBeEqualTo('*/*');
        $this::makeTypeMedia()->getDefaultSubTag()->shouldBeEqualTo('*');
        $this::makeTypeMedia()->getValueDelimiter()->shouldBeEqualTo('/');
    }

    function it_should_make_a_language_type()
    {
        $this::makeTypeLanguage()->shouldHaveType('ContentNegotiation\ContentType');
        $this::makeTypeLanguage()->shouldBeLanguageType();
        $this::makeTypeLanguage()->getDefaultValue()->shouldBeEqualTo('*');
        $this::makeTypeLanguage()->getDefaultSubTag()->shouldBeEqualTo('*');
        $this::makeTypeLanguage()->getValueDelimiter()->shouldBeEqualTo('-');
    }

    function it_should_make_a_charset_type()
    {
        $this::makeTypeCharset()->shouldHaveType('ContentNegotiation\ContentType');
        $this::makeTypeCharset()->shouldBeCharsetType();
        $this::makeTypeCharset()->getDefaultValue()->shouldBeEqualTo('*');
        $this::makeTypeCharset()->getDefaultSubTag()->shouldBeEqualTo('');
        $this::makeTypeCharset()->getValueDelimiter()->shouldBeEqualTo('');
    }
}
