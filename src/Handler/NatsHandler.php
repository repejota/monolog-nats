<?php
namespace MonologNats\Handler;

use Nats\Connection;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

/**
 * Class NatsHandler
 *
 * @package MonologNats\Handler
 */
class NatsHandler extends AbstractProcessingHandler
{
    /**
     * @var Connection
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
     * @param array $record
     */
    protected function write(array $record)
    {
        var_dump($record);
    }
}