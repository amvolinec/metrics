<?php

use Receiver\Metrics;

if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require 'autoload.php';
} else {
    require __DIR__ . '/../vendor/autoload.php';
}


$receiver = new Metrics();

// Return JSON string with result
echo $receiver->fetch() . PHP_EOL;