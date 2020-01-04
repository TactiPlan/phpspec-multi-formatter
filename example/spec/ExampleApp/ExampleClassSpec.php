<?php

namespace spec\ExampleApp;

use ExampleApp\ExampleClass;
use PhpSpec\ObjectBehavior;

class ExampleClassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExampleClass::class);
    }
}
