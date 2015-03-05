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
        $value1->getValue()->willReturn('value1');
        $value2->getValue()->willReturn('value2');
        $value3->getValue()->willReturn('value3');

        $headerField->getIterator()->willReturn(
            new \ArrayIterator([
                $value1->getWrappedObject(),
                $value2->getWrappedObject(),
                $value3->getWrappedObject(),
            ])
        );

        $supportedValues->hasExactValue('value1')->willReturn(false);
        $supportedValues->hasExactValue('value2')->willReturn(true);
        $supportedValues->hasExactValue('value3')->willReturn(false);

        $this::findFirstMatchingValue($headerField, $supportedValues)
            ->shouldHaveType('\ContentNegotiation\Header\Value');
        $this::findFirstMatchingValue($headerField, $supportedValues)->getValue()->shouldBeEqualTo('value2');
    }
}
