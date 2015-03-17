<?php

namespace spec\ContentNegotiation;

use ContentNegotiation\Header\Field;
use ContentNegotiation\Header\FieldTypeFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class FinderSpec
 * @package spec\ContentNegotiation
 */
class FinderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ContentNegotiation\Finder');
    }

    function it_should_find_the_client_header_matching_a_supported_value()
    {
        $preferred = new Field(
            FieldTypeFactory::makeTypeMedia(),
            'application/json, application/xml, application/atom+xml'
        );
        $supported = new Field(
            FieldTypeFactory::makeTypeMedia(),
            ['application/xml', 'application/atom+xml']
        );

        $this::findFirstPreferredValueMatchingASupportedValue($preferred, $supported)
            ->shouldHaveType('\ContentNegotiation\Header\Value');
        $this::findFirstPreferredValueMatchingASupportedValue($preferred, $supported)
            ->getValue()->shouldBeEqualTo('application/xml');
    }

    function it_should_find_first_supported_value_matching_a_preferred_value_with_accept_all_subtag()
    {
        $preferred = new Field(
            FieldTypeFactory::makeTypeMedia(),
            'application/*'
        );
        $supported = new Field(
            FieldTypeFactory::makeTypeMedia(),
            ['application/json', 'application/xml', 'application/atom+xml']
        );

        $this::findFirstSupportedValueMatchingAPreferredValueWithAcceptAllSubTag($preferred, $supported)
            ->shouldHaveType('\ContentNegotiation\Header\Value');
        $this::findFirstSupportedValueMatchingAPreferredValueWithAcceptAllSubTag($preferred, $supported)
            ->getValue()->shouldBeEqualTo('application/json');
    }

    function it_should_find_first_preferred_value_matching_a_supported_value_with_accept_all_subtag()
    {
        $preferred = new Field(
            FieldTypeFactory::makeTypeLanguage(),
            'fr-FR, fr-BE, fr-CH'
        );
        $supported = new Field(
            FieldTypeFactory::makeTypeLanguage(),
            ['fr']
        );

        $this::findFirstPreferredValueMatchingASupportedValueWithAcceptAllSubTag($preferred, $supported)
            ->shouldHaveType('\ContentNegotiation\Header\Value');
        $this::findFirstPreferredValueMatchingASupportedValueWithAcceptAllSubTag($preferred, $supported)
            ->getValue()->shouldBeEqualTo('fr-FR');
    }

    function it_should_return_the_first_supported_value_when_clent_accept_all()
    {
        $preferred = new Field(
            FieldTypeFactory::makeTypeMedia(),
            '*/*'
        );
        $supported = new Field(
            FieldTypeFactory::makeTypeMedia(),
            ['application/json', 'application/xml', 'application/atom+xml']
        );

        $this::findFirstSupportedValueWhenPreferredValueHasAcceptAllTag($preferred, $supported)
            ->shouldHaveType('\ContentNegotiation\Header\Value');
        $this::findFirstSupportedValueWhenPreferredValueHasAcceptAllTag($preferred, $supported)
            ->getValue()->shouldBeEqualTo('application/json');
    }
}
