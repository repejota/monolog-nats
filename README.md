# Monolog NATS

Monolog handler for sending logs to NATS (http://nats.io). Useful for async recording those logs on another machine.

* Develop [![CircleCI](https://circleci.com/gh/repejota/monolog-nats/tree/develop.svg?style=svg)](https://circleci.com/gh/repejota/monolog-nats/tree/develop)
* Master [![CircleCI](https://circleci.com/gh/repejota/monolog-nats/tree/master.svg?style=svg)](https://circleci.com/gh/repejota/monolog-nats/tree/master)

## Install

```bash
composer require repejota/monolog-nats
```

This will install this package itself [Monolog](https://packagist.org/packages/monolog/monolog) 
and [PHPNAts](https://github.com/repejota/phpnats), if they are not yet installed.

## Example

```php
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

```
