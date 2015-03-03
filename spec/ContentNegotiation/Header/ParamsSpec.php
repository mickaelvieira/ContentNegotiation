<?php

namespace spec\ContentNegotiation\Header;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParamsSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([
            'name1 = value1',
            'name2 = value2'
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('ContentNegotiation\Header\Params');
    }

    function it_should_be_countable()
    {
        $this->count()->shouldReturn(3);
    }

    function it_should_be_traversable()
    {
        $this->shouldImplement('Traversable');
    }

    function it_should_return_its_string_representation()
    {
        $this->__toString()->shouldBeEqualTo('name1=value1;name2=value2;q=1');
    }

    function it_should_return_all_params()
    {
        $param1 = new \ContentNegotiation\Header\Param('name1', 'value1');
        $param2 = new \ContentNegotiation\Header\Param('name2', 'value2');
        $param3 = new \ContentNegotiation\Header\Param('q', '1');

        $this->getParams()->shouldBeLike([$param1, $param2, $param3]);
    }

    function it_should_retrieve_a_param_by_its_name()
    {
        $this->getParam('name1')->getValue()->shouldBeEqualTo('value1');
        $this->getParam('name2')->getValue()->shouldBeEqualTo('value2');
        $this->getParam('q')->getValue()->shouldBeEqualTo('1');
    }
}
