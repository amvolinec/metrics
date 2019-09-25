<?php

use Receiver\Metrics;

require __DIR__ . '/../vendor/autoload.php';

$receiver = new Metrics();

// Return JSON string with result
echo $receiver->fetch() . PHP_EOL;