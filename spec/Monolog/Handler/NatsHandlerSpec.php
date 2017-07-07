<?php
namespace spec\Monolog\Handler;

use Nats\Connection;

use PhpSpec\ObjectBehavior;

class NatsHandlerSpec extends ObjectBehavior
{
    function let()
    {
        $nats = new Connection();
        $this->beConstructedWith($nats);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Monolog\Handler\NatsHandler');
    }
}