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
     * @param \ContentNegotiation\Header\Field\Media $headerField
     * @param \ContentNegotiation\Header\Field\Media $supportedValues
     */
    function it_should_find_the_client_header_matching_a_supported_value($value1, $value2, $value3, $headerField, $supportedValues)
    {
        $value1->getValue()->willReturn('application/json');
        $value2->getValue()->willReturn('text/html');
        $value3->getValue()->willReturn('audio/ogg');

        $headerField->getIterator()->willReturn(
            new \ArrayIterator([
                $value1->getWrappedObject(),
                $value2->getWrappedObject(),
                $value3->getWrappedObject(),
            ])
        );

        $supportedValues->hasExactValue('application/json')->willReturn(false);
        $supportedValues->hasExactValue('text/html')->willReturn(true);
        $supportedValues->hasExactValue('audio/ogg')->willReturn(true);

        $this::findFirstMatchingValue($headerField, $supportedValues)
            ->shouldHaveType('\ContentNegotiation\Header\Value');
        $this::findFirstMatchingValue($headerField, $supportedValues)
            ->getValue()->shouldBeEqualTo('text/html');
    }
}
