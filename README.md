## Task from Supermetrics

**src/script.php**

    <?php
    
    use Receiver\Metrics;
    
    if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
        require 'autoload.php';
    } else {
        require __DIR__ . '/../vendor/autoload.php';
    }
    
    $receiver = new Metrics();
    
    echo $receiver->fetch() . PHP_EOL;

## Requirements

PHP version 7.2 or later

## Getting started

$ composer install

## To run the task

$ cd src

$ php script.php

## Result 

For fictional user 'Rosann Eide'.

    protected $user = 'Rosann Eide'; // src/Receiver/Parser/Parser.php : 11 

JSON string, where:

average - Average character length / post / month (length | count | average)

longest - Longest post by character length / month ( id | length)

total_posts - Total posts split by week ( number of week { count: ## } )

average_posts_month - Average number of posts per user / month ( ## )

## PHPunit test

Simple unit test 

**tests/ParserTest.php**







