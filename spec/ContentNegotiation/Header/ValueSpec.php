<?php

namespace spec\ContentNegotiation\Header;

use ContentNegotiation\ContentTypeFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValueSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeCharset(), null);
        $this->shouldHaveType('ContentNegotiation\Header\Value');
    }

    function it_should_return_an_empty_string_when_input_is_empty()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeCharset(), '');
        $this->__toString()->shouldBeEqualTo('');
    }

    function it_should_return_the_charset_when_it_is_present_in_the_header_string()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeCharset(), 'iso-8859-5');
        $this->getValue()->shouldBeEqualTo('iso-8859-5');
    }

    function it_should_have_a_quality_equal_to_one_when_it_is_not_present_in_the_header_string()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeCharset(), 'iso-8859-5');
        $this->getQuality()->shouldBeEqualTo(1.0);
    }

    function it_should_return_the_quality_when_it_is_present_in_the_header_string()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeCharset(), 'unicode-1-1;q=0.8');
        $this->getQuality()->shouldBeEqualTo(0.8);
    }

    function it_should_be_split_the_specified_charset()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeCharset(), 'unicode-1-1;q=0.8');
        $this->shouldBeEqual('unicode-1-1');
    }

    function it_should_have_the_quality_equal_to_one_it_has_the_match_all_tag()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeCharset(), '*');
        $this->getQuality()->shouldBeEqualTo(1.0);
    }

    function it_should_return_the_language_range_when_it_is_present_in_the_header_string()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeLanguage(), 'da');
        $this->getValue()->shouldBeEqualTo('da');
    }

    function it_should_have_the_quality_equal_to_one_when_it_is_not_present_in_the_header_string()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeLanguage(), 'en-gb');
        $this->getQuality()->shouldBeEqualTo(1.0);
    }

    function it_should_be_aware_of_having_the_match_all_tag_when_it_is_present_in_the_header_string()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeLanguage(), '*; q=0.3');
        $this->shouldHaveAcceptAllTag();
    }

    function it_should_be_aware_of_having_the_match_all_sub_tag()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeLanguage(), 'fr', null, "-");
        $this->shouldHaveAcceptAllSubTag();
    }

    function it_should_be_aware_of_having_a_tag()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeLanguage(), 'fr-be', null, "-");
        $this->shouldHaveTag('fr');
    }

    function it_should_be_aware_of_having_a_sub_tag()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeLanguage(), 'fr-be', null, "-");
        $this->shouldHaveSubTag('be');
    }

    function it_should_be_aware_of_having_a_value_range()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeLanguage(), 'fr-be', null, "-");
        $this->shouldBeEqual('fr-be');
    }

    function it_should_return_the_media_range_when_it_is_present_in_the_header_string()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeMedia(), 'text/plain');
        $this->getValue()->shouldBeEqualTo('text/plain');
    }

    function it_should_have_a_media_range_with_quality_equal_to_one_when_it_is_not_present_in_the_header_string()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeMedia(), 'text/plain');
        $this->getQuality()->shouldBeEqualTo(1.0);
    }

    function it_should_return_the_string_representation()
    {
        $this->beConstructedWith(
            ContentTypeFactory::makeTypeMedia(),
            "text/html;mediaparam1=2;mediaparam2=2; q=0.4; extparam=whatever1; extparam2=whatever2"
        );
        $this->__toString()->shouldBeEqualTo(
            'text/html;mediaparam1=2;mediaparam2=2;q=0.4;extparam=whatever1;extparam2=whatever2'
        );
    }

    function it_should_be_aware_of_the_match_all_tag()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeMedia(), '*/*;q=0.4', null, "/");
        $this->shouldHaveTag("*");
        $this->shouldHaveSubTag("*");
        $this->shouldHaveAcceptAllTag();
    }

    function it_should_not_accept_all_when_it_has_only_the_accept_all_sub_tag()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeMedia(), 'audio/*;q=0.4', null, "/");

        $this->shouldHaveTag("audio");
        $this->shouldHaveSubTag("*");

        $this->shouldNotHaveAcceptAllTag();
    }

    function it_should_be_aware_of_the_match_all_sub_tag()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeMedia(), 'application/*;q=0.4', null, "/");
        $this->shouldHaveAcceptAllSubTag();
    }

    function it_should_return_the_quality_when_it_is_present_in_the_header_string_along_the_match_all_tag()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeMedia(), '*/*;q=0.4');
        $this->getQuality()->shouldBeEqualTo(0.4);
    }

    function it_should_be_aware_of_having_a_sub_media_type()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeMedia(), 'application/json;q=5', null, "/");
        $this->shouldHaveSubTag('json');
    }

    function it_should_be_aware_of_having_a_media_range()
    {
        $this->beConstructedWith(ContentTypeFactory::makeTypeMedia(), 'application/*;q=0.4', null, "/");
        $this->shouldBeEqual('application/*');
        $this->shouldHaveTag("application");
        $this->shouldHaveSubTag("*");
    }

    function it_should_return_a_parameter_by_name()
    {
        $this->beConstructedWith(
            ContentTypeFactory::makeTypeMedia(),
            "text/html;mediaparam1=value1;mediaparam2=value2; q=0.4; extparam=whatever1; extparam2=whatever2"
        );
        $this->getParam('mediaparam1')->shouldHaveType('ContentNegotiation\Header\Param');
        $this->getParam('mediaparam1')->getValue()->shouldBeEqualTo('value1');
        $this->getParam('mediaparam2')->shouldHaveType('ContentNegotiation\Header\Param');
        $this->getParam('mediaparam2')->getValue()->shouldBeEqualTo('value2');
        $this->getParam('q')->shouldHaveType('ContentNegotiation\Header\Param');
        $this->getParam('q')->getValue()->shouldBeEqualTo('0.4');
        $this->getParam('extparam')->shouldHaveType('ContentNegotiation\Header\Param');
        $this->getParam('extparam')->getValue()->shouldBeEqualTo('whatever1');
        $this->getParam('extparam2')->shouldHaveType('ContentNegotiation\Header\Param');
        $this->getParam('extparam2')->getValue()->shouldBeEqualTo('whatever2');
    }
}
