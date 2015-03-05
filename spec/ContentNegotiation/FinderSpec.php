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
        $value2->getValue()->willReturn('text/html');
        $value3->getValue()->willReturn('audio/ogg');

        $preferred->getIterator()->willReturn(
            new \ArrayIterator([
                $value1->getWrappedObject(),
                $value2->getWrappedObject(),
                $value3->getWrappedObject(),
            ])
        );

        $supported->hasExactValue('application/json')->willReturn(false);
        $supported->hasExactValue('text/html')->willReturn(true);
        $supported->hasExactValue('audio/ogg')->willReturn(true);

        $this::findFirstPreferredValueMatchingASupportedValue($preferred, $supported)
            ->shouldHaveType('\ContentNegotiation\Header\Value');
        $this::findFirstPreferredValueMatchingASupportedValue($preferred, $supported)
            ->getValue()->shouldBeEqualTo('text/html');
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
        $value2->getTag()->willReturn('text');
        $value2->getValue()->willReturn('text/html');
        $value3->getTag()->willReturn('audio');
        $value3->getValue()->willReturn('audio/ogg');

        $supported->getIterator()->willReturn(
            new \ArrayIterator([
                $value1->getWrappedObject(),
                $value2->getWrappedObject(),
                $value3->getWrappedObject(),
            ])
        );

        $preferred->hasAcceptAllSubTag('application')->willReturn(false);
        $preferred->hasAcceptAllSubTag('text')->willReturn(false);
        $preferred->hasAcceptAllSubTag('audio')->willReturn(true);

        $this::findFirstSupportedValueMatchingAPreferredValueWithAcceptAllSubTag($preferred, $supported)
            ->shouldHaveType('\ContentNegotiation\Header\Value');
        $this::findFirstSupportedValueMatchingAPreferredValueWithAcceptAllSubTag($preferred, $supported)
            ->getValue()->shouldBeEqualTo('audio/ogg');
    }
}
