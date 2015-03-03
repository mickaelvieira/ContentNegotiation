<?php

namespace spec\ContentNegotiation\AcceptHeader\Field;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class MediaSpec
 * @package spec\ContentNegotiation\Header\Field
 */
class MediaSpec extends ObjectBehavior
{
    /**
     *
     */
    // text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
    function it_is_initializable()
    {
        $this->beConstructedWith(null);
        $this->shouldHaveType('ContentNegotiation\AcceptHeader\Field\Media');
    }

    function it_should_return_the_accept_all_tag_when_the_header_string_is_null()
    {
        $this->beConstructedWith(null);
        $this->__toString()->shouldBeEqualTo('*/*;q=1');
    }

    function it_should_return_the_accept_all_tag_when_the_header_string_is_empty()
    {
        $this->beConstructedWith('');
        $this->__toString()->shouldBeEqualTo('*/*;q=1');
    }

    function it_should_be_aware_of_having_the_accept_all_tag()
    {
        $this->beConstructedWith('text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8');
        $this->shouldHaveAcceptAllTag();
    }

    function it_should_be_aware_of_having_the_accept_all_tag_for_a_specific_type()
    {
        $this->beConstructedWith('text/html,image/*,application/xml;q=0.9,*/*;q=0.8');
        $this->shouldHaveAcceptAllSubTag('image');
    }

    function it_should_be_aware_of_having_a_value_range()
    {
        $this->beConstructedWith('audio/webm, audio/ogg, audio/wav, audio/*;q=0.9, application/ogg;q=0.7, video/*;q=0.6; */*;q=0.5');
        $this->shouldHaveExactValue('audio/ogg');
    }

    function it_should_sort_the_entities()
    {
        $this->beConstructedWith('text/*,text/html,text/html;level=1,*/*');
        $this->__toString()->shouldBeEqualTo('text/html;level=1;q=1,text/html;q=1,text/*;q=1,*/*;q=1');
    }

    function it_should_return_the_first_matching_value()
    {
        $this->beConstructedWith('audio/webm, audio/ogg, audio/wav, audio/*;q=0.9, application/ogg;q=0.7, video/*;q=0.6; */*;q=0.5');
        $this->findFirstMatchingValue(['audio/ogg', 'audio/wav'])->shouldHaveType('ContentNegotiation\AcceptHeader\Value\Media');
        $this->findFirstMatchingValue(['audio/ogg', 'audio/wav'])->getValue()->shouldBeEqualTo('audio/ogg');
    }

    function it_should_return_null_where_there_is_no_matching_value()
    {
        $this->beConstructedWith('audio/webm, audio/ogg, audio/wav, audio/*;q=0.9, application/ogg;q=0.7, video/*;q=0.6; */*;q=0.5');
        $this->findFirstMatchingValue(['audio/ac3'])->shouldBeNull();
    }

    function it_should_return_the_first_matching_sub_value()
    {
        $this->beConstructedWith('audio/webm, audio/ogg, audio/wav, audio/*;q=0.9, application/ogg;q=0.7, video/*;q=0.6; */*;q=0.5');
        $this->findFirstMatchingSubValue(['text/html', 'audio/ac3', 'video/encaprtp'])->shouldBeEqualTo('audio/ac3');
    }

    function it_should_return_null_where_there_is_no_matching_sub_value()
    {
        $this->beConstructedWith('audio/webm, audio/ogg, audio/wav, audio/*;q=0.9, application/ogg;q=0.7, video/*;q=0.6; */*;q=0.5');
        $this->findFirstMatchingSubValue(['text/html', 'application/json'])->shouldBeNull();
    }
}
