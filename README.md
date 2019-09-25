## Task from Supermetrics
Aleksandr Volynec

    <?php
    
    use Receiver\Metrics;
    
    require __DIR__ . '/../vendor/autoload.php';
    
    $receiver = new Metrics();
    
    // Return JSON string with result
    echo $receiver->fetch() . PHP_EOL;

## Requirements

PHP version 7.2 or later

## Getting started

$ composer install

## To run task

$ cd src

$ php script.php

## Result 

JSON string, where:

average - Average character length / post / month (length | count | average)\n

longest - Longest post by character length / month ( id | length)\n

total_posts - Total posts split by week ( number of week { count: ## } )\n

average_posts_month - Average number of posts per user / month ( ## )\n







