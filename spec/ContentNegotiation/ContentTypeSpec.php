<?php

namespace spec\ContentNegotiation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class TypeSpec
 * @package spec\ContentNegotiation
 */
class ContentTypeSpec extends ObjectBehavior
{
    function it_should_return_its_name()
    {
        $this->beConstructedWith('my name', 'my default value', 'my default sub tag', 'my value delimiter');
        $this->getDefaultValue()->shouldBeEqualTo('my default value');
        $this->getDefaultSubTag()->shouldBeEqualTo('my default sub tag');
        $this->getValueDelimiter()->shouldBeEqualTo('my value delimiter');

        $this->shouldHaveType('ContentNegotiation\ContentType');
    }

    function it_should_know_when_is_a_media_type()
    {
        $this->beConstructedWith('media', 'my default value', 'my value delimiter', 'my default sub tag');
        $this->shouldBeMediaType();
        $this->shouldNotBeLanguageType();
        $this->shouldNotBeCharsetType();
    }

    function it_should_know_when_is_a_language_type()
    {
        $this->beConstructedWith('language', 'my default value', 'my value delimiter', 'my default sub tag');
        $this->shouldNotBeMediaType();
        $this->shouldBeLanguageType();
        $this->shouldNotBeCharsetType();
    }

    function it_should_know_when_is_a_charset_type()
    {
        $this->beConstructedWith('charset', 'my default value', 'my value delimiter', 'my default sub tag');
        $this->shouldNotBeMediaType();
        $this->shouldNotBeLanguageType();
        $this->shouldBeCharsetType();
    }
}
