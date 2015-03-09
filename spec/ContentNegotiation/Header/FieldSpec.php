<?php

namespace spec\ContentNegotiation\Header;

use ContentNegotiation\Header\Value;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FieldSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('charset', null);
        $this->shouldHaveType('ContentNegotiation\Header\Field');
    }


    // -----------------------------------------------------------
    function it_should_return_the_default_charset_when_the_header_string_is_null()
    {
        $this->beConstructedWith('charset', null);
        $this->__toString()->shouldBeEqualTo('*;q=1');
    }

    function it_should_return_the_default_charset_when_the_header_string_is_empty()
    {
        $this->beConstructedWith('charset', '');
        $this->__toString()->shouldBeEqualTo('*;q=1');
    }

    function it_should_be_aware_of_charset_having_the_accept_all_tag()
    {
        $this->beConstructedWith('charset', 'iso-8859-5, *, unicode-1-1;q=0.8');
        $this->shouldHaveAcceptAllTag();
    }

    function it_should_never_have_an_accept_all_sub_tag()
    {
        $this->beConstructedWith('charset', 'iso-8859-5, *, unicode-1-1;q=0.8');
        $this->shouldNotHaveAcceptAllSubTag('iso-8859-5');
    }

    function it_should_be_aware_of_having_a_value_range()
    {
        $this->beConstructedWith('charset', 'iso-8859-5;q=1,iso-8859-1;q=1,unicode-1-1;q=0.8');
        $this->shouldHaveExactValue('unicode-1-1');
    }

    function it_should_return_values_matching_a_tag()
    {
        $value = new Value('unicode-1-1', 2, "");
        $this->beConstructedWith('charset', 'iso-8859-5, iso-8859-1, unicode-1-1');

        $this->getValuesWithTag('unicode-1-1')->shouldBeLike([$value]);
    }

    function it_should_sort_the_charset()
    {
        $this->beConstructedWith('charset', 'utf-7;q=0.5, iso-8859-5, unicode-1-1;q=0.8');
        $this->__toString()->shouldBeEqualTo('iso-8859-5;q=1,unicode-1-1;q=0.8,utf-7;q=0.5');
    }

    function it_should_sort_the_charset_with_accept_all_tag()
    {
        $this->beConstructedWith('charset', 'utf-8, utf-7, *;q=0.3, iso-8859-1, unicode-1-1;q=0.8');
        $this->__toString()->shouldBeEqualTo('utf-8;q=1,utf-7;q=1,iso-8859-1;q=1,unicode-1-1;q=0.8,*;q=0.3');
    }

    /*function it_should_return_the_first_matching_value()
    {
        $this->beConstructedWith('utf-8, utf-7, *;q=0.3, iso-8859-1, unicode-1-1;q=0.8');
        $this->findFirstMatchingValue(['utf-8', 'utf-7'])->shouldHaveType('ContentNegotiation\Header\Value\Charset');
        $this->findFirstMatchingValue(['utf-8', 'utf-7'])->getValue()->shouldBeEqualTo('utf-8');
    }

    function it_should_return_null_where_there_is_no_matching_value()
    {
        $this->beConstructedWith('utf-8, utf-7, *;q=0.3, unicode-1-1;q=0.8');
        $this->findFirstMatchingValue(['iso-8859-1'])->shouldBeNull();
    }

    function it_should_return_always_return_null_when_search_a_sub_value()
    {
        $this->beConstructedWith('utf-8, utf-7, *;q=0.3, iso-8859-1, unicode-1-1;q=0.8');
        $this->findFirstMatchingSubValue(['utf-8'])->shouldBeNull();
    }*/

    // -----------------------------------------------------------

    function it_should_return_the_accept_all_tag_when_the_header_string_is_null()
    {
        $this->beConstructedWith('language', null);
        $this->__toString()->shouldBeEqualTo('*;q=1');
    }

    function it_should_return_the_accept_all_tag_when_the_header_string_is_empty()
    {
        $this->beConstructedWith('language', '');
        $this->__toString()->shouldBeEqualTo('*;q=1');
    }

    function it_should_be_aware_of_language_having_the_accept_all_tag()
    {
        $this->beConstructedWith('language', 'da, en-gb;q=0.8, *, en;q=0.7');
        $this->shouldHaveAcceptAllTag();
    }

    function it_should_be_aware_of_having_the_accept_all_sub_tag_for_a_specific_tag()
    {
        $this->beConstructedWith('language', 'da, en-gb;q=0.8, *, en;q=0.7');
        $this->shouldHaveAcceptAllSubTag('da');
    }

    function it_should_sort_the_language()
    {
        $this->beConstructedWith('language', 'es-ES;q=0.7, es; q=0.6 ,fr; q=1, en; q=0.5,da , fr-BE');
        $this->__toString()->shouldBeEqualTo('fr;q=1,da;q=1,fr-BE;q=1,es-ES;q=0.7,es;q=0.6,en;q=0.5');
    }

    function it_should_sort_the_language_with_accept_all_tag()
    {
        $this->beConstructedWith('language', 'es-ES;q=0.7, es; q=0.6 ,fr; q=1, *;q=0.3, fr-CH');
        $this->__toString()->shouldBeEqualTo('fr;q=1,fr-CH;q=1,es-ES;q=0.7,es;q=0.6,*;q=0.3');
    }

    function it_should_be_aware_of_having_a_language_value_range()
    {
        $this->beConstructedWith('language', 'es-ES;q=0.7, es; q=0.6 ,fr; q=1.0, *;q=0.3, fr-CH');
        $this->shouldHaveExactValue('fr-CH');
    }

    function it_should_return_language_matching_a_tag()
    {
        $value1 = new Value('fr-FR', 0, "-");
        $value2 = new Value('fr-BE', 1, "-");
        $value3 = new Value('fr-CH', 2, "-");
        $this->beConstructedWith('language', 'fr-FR, fr-BE, fr-CH');

        $this->getValuesWithTag('fr')->shouldBeLike([
            $value1, $value2, $value3
        ]);
    }

    /** broken test reference */
    /*function it_should_return_the_first_matching_value()
    {
        $this->beConstructedWith('es-ES;q=0.7, es;q=0.6, fr;q=1.0, *;q=0.3, fr-CH');
        $this->findFirstMatchingValue(['fr-CH', 'fr-FR'])
            ->shouldHaveType('ContentNegotiation\Header\Value\Language');
        $this->findFirstMatchingValue(['fr-CH', 'fr-FR'])->getValue()->shouldBeEqualTo('fr-CH');
    }*/

    /*function it_should_return_null_where_there_is_no_matching_value()
    {
        $this->beConstructedWith('es-ES;q=0.7, es;q=0.6, fr;q=1.0, *;q=0.3, fr-CH');
        $this->findFirstMatchingValue(['de'])->shouldBeNull();
    }*/

    /*function it_should_return_the_first_matching_sub_value()
    {
        $this->beConstructedWith('es-ES;q=0.7, es; q=0.6 ,fr; q=1.0, *;q=0.3, fr-CH');
        $this->findFirstMatchingSubValue(['fr-FR', 'fr-CH'])->shouldBeEqualTo('fr-FR');
    }*/

    /*function it_should_return_null_where_there_is_no_matching_sub_value()
    {
        $this->beConstructedWith('es-ES;q=0.7, es; q=0.6 ,fr; q=1.0, *;q=0.3, fr-CH');
        $this->findFirstMatchingSubValue(['de', 'da'])->shouldBeNull();
    }*/

    // -----------------------------------------------------------

    function it_should_return_the_media_accept_all_tag_when_the_header_string_is_empty()
    {
        $this->beConstructedWith('media', '');
        $this->__toString()->shouldBeEqualTo('*/*;q=1');
    }

    function it_should_be_aware_of_media_having_the_accept_all_tag()
    {
        $this->beConstructedWith('media','text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8');
        $this->shouldHaveAcceptAllTag();
    }

    function it_should_be_aware_of_having_the_accept_all_tag_for_a_specific_type()
    {
        $this->beConstructedWith('media', 'text/html,image/*,application/xml;q=0.9,*/*;q=0.8');
        $this->shouldHaveAcceptAllSubTag('image');
    }

    function it_should_be_aware_of_having_a_media_value_range()
    {
        $this->beConstructedWith('media', 'audio/webm, audio/ogg, audio/wav, audio/*;q=0.9, application/ogg;q=0.7, video/*;q=0.6; */*;q=0.5');
        $this->shouldHaveExactValue('audio/ogg');
    }

    function it_should_sort_the_media_ranges()
    {
        $this->beConstructedWith('media', 'text/*,text/html,text/html;level=1,*/*');
        $this->__toString()->shouldBeEqualTo('text/html;level=1;q=1,text/html;q=1,text/*;q=1,*/*;q=1');
        // text/*,text/html,text/html;level=1,*/*
        // text/html;level=1;q=1,text/html;q=1,text/*;q=1,*/*;q=1
        // text/html;level=1;q=1,text/*;q=1,text/html;q=1,*/*;q=1
    }

    //function it_should_return_the_first_matching_value()
    //{
     //   $this->beConstructedWith('audio/webm, audio/ogg, audio/wav, audio/*;q=0.9, application/ogg;q=0.7, video/*;q=0.6; */*;q=0.5');
     //   $this->findFirstMatchingValue(['audio/ogg', 'audio/wav'])->shouldHaveType('ContentNegotiation\Header\Value\Media');
     //   $this->findFirstMatchingValue(['audio/ogg', 'audio/wav'])->getValue()->shouldBeEqualTo('audio/ogg');
    //}

    //function it_should_return_null_where_there_is_no_matching_value()
    //{
    //    $this->beConstructedWith('audio/webm, audio/ogg, audio/wav, audio/*;q=0.9, application/ogg;q=0.7, video/*;q=0.6; */*;q=0.5');
    //    $this->findFirstMatchingValue(['audio/ac3'])->shouldBeNull();
    //}

    //function it_should_return_the_first_matching_sub_value()
    //{
    //    $this->beConstructedWith('audio/webm, audio/ogg, audio/wav, audio/*;q=0.9, application/ogg;q=0.7, video/*;q=0.6; */*;q=0.5');
    //    $this->findFirstMatchingSubValue(['text/html', 'audio/ac3', 'video/encaprtp'])->shouldBeEqualTo('audio/ac3');
    //}

    //function it_should_return_null_where_there_is_no_matching_sub_value()
    //{
     //   $this->beConstructedWith('audio/webm, audio/ogg, audio/wav, audio/*;q=0.9, application/ogg;q=0.7, video/*;q=0.6; */*;q=0.5');
     //   $this->findFirstMatchingSubValue(['text/html', 'application/json'])->shouldBeNull();
    //}
}
