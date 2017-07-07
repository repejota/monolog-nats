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
     * Prefix used to build the message subject.
     *
     * @var string $prefix
     */
    private $prefix = "";

    /**
     * Get the prefix used to build the mesage subject.
     *
     * @return string Subject prefix.
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Get the prefix used to build the mesage subject.
     *
     * @param string $prefix Subject prefix.
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

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
     * Get the subject of the message to send.
     *
     * @param array $record
     * @return string Message subject.
     */
    protected function getSubject(array $record)
    {
        $subject = $this->getPrefix().$record['channel'].".".$record['level_name'];
        return $subject;
    }

    /**
     * Get the payload of the messageto send.
     *
     * @param array $record
     * @return mixed
     */
    protected function getPayload(array $record)
    {
        return $record['formatted'];
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  array $record
     * @return void
     */
    protected function write(array $record)
    {
        $subject = $this->getSubject($record);
        $payload = $this->getPayload($record);
        $this->nats->publish($subject, $payload);
    }
}
