<?php
require_once __DIR__.'/../vendor/autoload.php';

use Monolog\Logger;

use Nats\Connection;

use MonologNats\Handler\NatsHandler;

$nats = new Connection();

$logger = new Logger("monolog-nats-logger");
$handler = new NatsHandler($nats);