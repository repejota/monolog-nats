<?php
namespace spec\Monolog\Handler;

use Nats\Connection;

use PhpSpec\ObjectBehavior;

use Monolog\Logger;
use Monolog\Handler\NatsHandler;

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

    function it_has_blank_prefix_by_default() {
        $this->getPrefix()->shouldBeLike("");
    }

    function it_allows_to_set_a_prefix_string() {
        $expected_prefix = "foo-";
        $this->setPrefix($expected_prefix);
        $this->getPrefix()->shouldBeLike($expected_prefix);
    }

    function it_logs_an_INFO_message()
    {
        $nats = new Connection();
        $nats->connect();

        $logger = new Logger("monolog-nats-logger");
        $natsHandler = new NatsHandler($nats);
        $logger->pushHandler($natsHandler);

        $logger->info("Info log");
    }

    function it_logs_an_INFO_message_with_prefix()
    {
        $nats = new Connection();
        $nats->connect();

        $logger = new Logger("monolog-nats-logger");
        $natsHandler = new NatsHandler($nats);
        $logger->pushHandler($natsHandler);

        $natsHandler->setPrefix("prefix");

        $logger->info("Info log");
    }
}