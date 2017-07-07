<?php
namespace Monolog\Handler;

use Nats\Connection;

use Monolog\Logger;
use Monolog\Formatter\JsonFormatter;

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
     * {@inheritDoc}
     */
    protected function write(array $record)
    {
        $subject = $record['channel'].".".$record['level_name'];
        $this->nats->publish($subject, $record['formatted']);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter()
    {
        return new JsonFormatter(JsonFormatter::BATCH_MODE_JSON, false);
    }
}