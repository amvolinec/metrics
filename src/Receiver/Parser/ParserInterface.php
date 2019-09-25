<?php

namespace Receiver\Parser;

interface ParserInterface
{
    /**
     * protected $data;
     * protected $result = array(
     *    'average' => 0,
     *    'longest' => '',
     *    'total_posts' => 0,
     *    'average_posts_month' => 0
     * );
     *
     * /**
     * @param $data
     */
    public function setData($data = array()): void;

    /**
     * @return void
     */
    public function parseData(): void;

    /**
     * @return array
     */
    public function getResult(): array;
}