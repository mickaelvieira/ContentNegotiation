<?php

namespace spec\ContentNegotiation\Header;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class FieldTypeSpec
 * @package spec\ContentNegotiation\Header
 */
class FieldTypeSpec extends ObjectBehavior
{
    function it_should_have_getters()
    {
        $this->beConstructedWith('my name', 'my default value', 'my default sub tag', 'my value delimiter');
        $this->getDefaultValue()->shouldBeEqualTo('my default value');
        $this->getDefaultSubTag()->shouldBeEqualTo('my default sub tag');
        $this->getValueDelimiter()->shouldBeEqualTo('my value delimiter');

        $this->shouldHaveType('ContentNegotiation\Header\FieldType');
    }

    function it_should_know_when_it_is_a_media_type()
    {
        $this->beConstructedWith('media', 'my default value', 'my value delimiter', 'my default sub tag');
        $this->shouldBeMediaType();
        $this->shouldNotBeLanguageType();
        $this->shouldNotBeCharsetType();
    }

    function it_should_know_when_it_is_a_language_type()
    {
        $this->beConstructedWith('language', 'my default value', 'my value delimiter', 'my default sub tag');
        $this->shouldNotBeMediaType();
        $this->shouldBeLanguageType();
        $this->shouldNotBeCharsetType();
    }

    function it_should_know_when_it_is_a_charset_type()
    {
        $this->beConstructedWith('charset', 'my default value', 'my value delimiter', 'my default sub tag');
        $this->shouldNotBeMediaType();
        $this->shouldNotBeLanguageType();
        $this->shouldBeCharsetType();
    }
}
