## Task
Aleksandr Volynec

In order to run task you should run 

$ composer install

##Getting started

`
<?php

use Receiver\Metrics;

require __DIR__ . '/../vendor/autoload.php';

$receiver = new Metrics();

// Return JSON string with result
echo $receiver->fetch() . PHP_EOL;
`

##Requirements

PHP version 7.2 or later





