<?php

namespace Receiver\Parser;

use Receiver\Provider\ProviderInterface;

class Parser implements ParserInterface
{
    protected $data;
    protected $result = array();

    public function __construct()
    {
        $result['average'] = array();
        $result['longest'] = array();
        $result['total_posts'] = array();
        $result['average_posts_month'] = array();
    }

    /**
     * @param $data
     * @return void
     */
    public function setData($data = array()): void
    {
        $this->data = $data;
        $this->decodeData();
        if (!isset($this->data['data']['posts']) ||
            empty($this->data['data']['posts'] ||
                !is_array($this->data['data']['posts']))) {
            throw new \RuntimeException('Undefined data', 100);
        }
    }

    protected function decodeData(): array
    {
        return is_array($this->data) ? $this->data : json_decode($this->data, true);
    }

    /**
     * @return void
     */
    public function parseData(): void
    {
        foreach ($this->data['data']['posts'] AS $post) {
            if ('Rosann Eide' === $post['from_name']) {

                $post_len = strlen($post['message']);
                $month = substr($post['created_time'], 0, 7);
                $week = $this->getWeekNumber($post['created_time']);

                $this->addMonthLength($month, $post_len);
                $this->addMonthCount($month);
                $this->addWeekCount($week);
                $this->addLongestPost($month, $post['id'], $post_len);
            }
        }

        $this->result['average_posts_month'] = $this->calcAverage();
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @return int
     */
    protected function calcAverage(): int
    {
        $total = 0;
        foreach ($this->result['average'] AS &$month) {
            $month['average'] = (int)round($month['length'] / $month['count']);
            $total += $month['count'];
        }
        return (int)round($total / count($this->result['average']));
    }

    protected function getWeekNumber($date): string
    {
        return date('W', strtotime($date));
    }

    /**
     * @param $month
     * @param $post_len
     */
    protected function addMonthLength($month, $post_len): void
    {
        if (!isset($this->result['average'][$month]['length'])) {
            $this->result['average'][$month]['length'] = $post_len;
        } else {
            $this->result['average'][$month]['length'] += $post_len;
        }
    }

    /**
     * @param $month
     */
    protected function addMonthCount($month): void
    {
        if (!isset($this->result['average'][$month]['count'])) {
            $this->result['average'][$month]['count'] = 1;
        } else {
            $this->result['average'][$month]['count']++;
        }
    }

    /**
     * @param $week
     */
    protected function addWeekCount($week): void
    {
        if (!isset($this->result['total_posts'][$week]['count'])) {
            $this->result['total_posts'][$week]['count'] = 1;
        } else {
            $this->result['total_posts'][$week]['count']++;
        }
    }

    /**
     * @param $month
     * @param $post_id
     * @param $post_len
     */
    protected function addLongestPost($month, $post_id, $post_len): void
    {
        if (!isset($this->result['longest'][$month]) || $this->result['longest'][$month]['length'] < $post_len) {
            $this->result['longest'][$month] = array('id' => $post_id, 'length' => $post_len);
        }
    }
}