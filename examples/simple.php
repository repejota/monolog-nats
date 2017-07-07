<?php
require_once __DIR__.'/../vendor/autoload.php';

use Nats\Connection;

use Monolog\Logger;
use Monolog\Handler\NatsHandler;

$nats = new Connection();
$nats->connect();

$logger = new Logger("monolog-nats-logger");
$natsHandler = new NatsHandler($nats);
$logger->pushHandler($natsHandler);

$logger->info("Info log");

