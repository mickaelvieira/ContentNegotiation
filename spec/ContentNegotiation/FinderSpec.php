<?php

namespace spec\ContentNegotiation;

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

    /**
     * @param \ContentNegotiation\Header\Value\Media $value1
     * @param \ContentNegotiation\Header\Value\Media $value2
     * @param \ContentNegotiation\Header\Value\Media $value3
     * @param \ContentNegotiation\Header\Field\Media $preferred
     * @param \ContentNegotiation\Header\Field\Media $supported
     */
    function it_should_find_the_client_header_matching_a_supported_value(
        $value1, $value2, $value3, $preferred, $supported
    )
    {
        $value1->getValue()->willReturn('application/json');
        $value2->getValue()->willReturn('application/xml');
        $value3->getValue()->willReturn('application/atom+xml');

        $preferred->getIterator()->willReturn(
            new \ArrayIterator([
                $value1->getWrappedObject(),
                $value2->getWrappedObject(),
                $value3->getWrappedObject(),
            ])
        );

        $supported->hasExactValue('application/json')->willReturn(false);
        $supported->hasExactValue('application/xml')->willReturn(true);
        $supported->hasExactValue('application/atom+xml')->willReturn(true);

        $this::findFirstPreferredValueMatchingASupportedValue($preferred, $supported)
            ->shouldHaveType('\ContentNegotiation\Header\Value');
        $this::findFirstPreferredValueMatchingASupportedValue($preferred, $supported)
            ->getValue()->shouldBeEqualTo('application/xml');
    }

    /**
     * @param \ContentNegotiation\Header\Value\Media $value1
     * @param \ContentNegotiation\Header\Value\Media $value2
     * @param \ContentNegotiation\Header\Value\Media $value3
     * @param \ContentNegotiation\Header\Field\Media $preferred
     * @param \ContentNegotiation\Header\Field\Media $supported
     */
    function it_should_find_first_supported_value_matching_a_preferred_value_with_accept_all_subtag(
        $value1, $value2, $value3, $preferred, $supported
    )
    {
        $value1->getTag()->willReturn('application');
        $value1->getValue()->willReturn('application/json');
        $value1->hasAcceptAllTag()->willReturn(false);

        $value2->getTag()->willReturn('application');
        $value2->getValue()->willReturn('application/xml');
        $value2->hasAcceptAllTag()->willReturn(false);

        $value3->getTag()->willReturn('application');
        $value3->getValue()->willReturn('application/atom+xml');
        $value3->hasAcceptAllTag()->willReturn(false);

        $supported->getIterator()->willReturn(
            new \ArrayIterator([
                $value1->getWrappedObject(),
                $value2->getWrappedObject(),
                $value3->getWrappedObject(),
            ])
        );

        $preferred->hasAcceptAllSubTag('application')->willReturn(true);

        $this::findFirstSupportedValueMatchingAPreferredValueWithAcceptAllSubTag($preferred, $supported)
            ->shouldHaveType('\ContentNegotiation\Header\Value');
        $this::findFirstSupportedValueMatchingAPreferredValueWithAcceptAllSubTag($preferred, $supported)
            ->getValue()->shouldBeEqualTo('application/json');
    }

    /**
     * @param \ContentNegotiation\Header\Value\Language $value1
     * @param \ContentNegotiation\Header\Value\Language $value2
     * @param \ContentNegotiation\Header\Value\Language $value3
     * @param \ContentNegotiation\Header\Value\Language $value4
     * @param \ContentNegotiation\Header\Field\Language $preferred
     * @param \ContentNegotiation\Header\Field\Language $supported
     */
    function it_should_find_first_preferred_value_matching_a_supported_value_with_accept_all_subtag(
        $value1, $value2, $value3, $value4, $preferred, $supported
    )
    {
        $value1->getTag()->willReturn('fr');
        $value1->hasAcceptAllTag()->willReturn(false);
        $value1->hasAcceptAllSubTag()->willReturn(false);

        $value2->getValue()->willReturn('fr-FR');
        $value3->getValue()->willReturn('fr-BE');
        $value4->getValue()->willReturn('fr-CH');

        $supported->getIterator()->willReturn(
            new \ArrayIterator([
                $value1->getWrappedObject()
            ])
        );

        $preferred->getValuesWithTag('fr')->willReturn([
            $value2, $value3, $value4
        ]);

        $this::findFirstPreferredValueMatchingASupportedValueWithAcceptAllSubTag($preferred, $supported)
            ->shouldHaveType('\ContentNegotiation\Header\Value');
        $this::findFirstPreferredValueMatchingASupportedValueWithAcceptAllSubTag($preferred, $supported)
            ->getValue()->shouldBeEqualTo('fr-FR');
    }


    /**
     * @param \ContentNegotiation\Header\Value\Media $value1
     * @param \ContentNegotiation\Header\Value\Media $value2
     * @param \ContentNegotiation\Header\Value\Media $value3
     * @param \ContentNegotiation\Header\Field\Media $preferred
     * @param \ContentNegotiation\Header\Field\Media $supported
     */
    function it_should_return_the_first_supported_value_when_clent_accept_all(
        $value1, $value2, $value3, $preferred, $supported
    )
    {
        $value1->getTag()->willReturn('application');
        $value1->getValue()->willReturn('application/json');

        $value2->getTag()->willReturn('application');
        $value2->getValue()->willReturn('application/xml');

        $value3->getTag()->willReturn('application');
        $value3->getValue()->willReturn('application/atom+xml');

        $supported->count()->willReturn(3);
        $supported->getIterator()->willReturn(
            new \ArrayIterator([
                $value1->getWrappedObject(),
                $value2->getWrappedObject(),
                $value3->getWrappedObject(),
            ])
        );

        $preferred->hasAcceptAllTag()->willReturn(true);

        $this::findFirstSupportedValueWhenPreferredValueHasAcceptAllTag($preferred, $supported)
            ->shouldHaveType('\ContentNegotiation\Header\Value');
        $this::findFirstSupportedValueWhenPreferredValueHasAcceptAllTag($preferred, $supported)
            ->getValue()->shouldBeEqualTo('application/json');
    }
}
