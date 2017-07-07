<?php
namespace Monolog\Handler;

use Nats\Connection;

use Monolog\Logger;

/**
 * Class NatsHandler
 *
 * @package MonologNats\Handler
 */
class NatsHandler extends AbstractProcessingHandler
{
    /**
     * Connection to NATS server.
     *
     * @var Connection $nats Connection to NATS server.
     */
    private $nats;

    /**
     * NatsHandler constructor.
     *
     * @param Connection $nats
     * @param bool|int $level
     * @param bool $bubble
     */
    public function __construct(Connection $nats, $level = Logger::DEBUG, $bubble = true)
    {
        $this->nats = $nats;

        parent::__construct($level, $bubble);
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  array $record
     * @return void
     */
    protected function write(array $record)
    {
        $subject = $record['channel'].".".$record['level_name'];
        $this->nats->publish($subject, $record['formatted']);
    }
}
