#! /usr/bin/env php

<?php

require_once(__DIR__ . "/vendor/autoload.php");

use FelixRupp\iCalNotificationGenerator\Command\AddNotification;
use Symfony\Component\Console\Application;

/**
 * @var Application
 */
$app = new Application();

$app->add(new AddNotification());

$app->run();