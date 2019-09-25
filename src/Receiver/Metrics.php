<?php

namespace Receiver;


use Receiver\Provider\ProviderGuzzle;
use Receiver\Parser\Parser;

class Metrics
{
    protected $token = false;
    protected $provider;
    protected $data;
    protected $parser;
    protected $result;

    /**
     * @return string
     */
    public function fetch(): string
    {
        echo 'process is started...' . PHP_EOL;

        $this->provider = new ProviderGuzzle();

        $this->parser = new Parser();

        $this->token = $this->provider->getToken();

        echo 'received token: ' . $this->token . PHP_EOL;

        for ($i = 0; $i <= 10; $i++) {
            $this->data = $this->provider->getData($i, $this->token);

            printf('data from page #%s received' . PHP_EOL, $i);

            try {
                $this->parser->setData($this->data);
                $this->parser->parseData();

            } catch (\Exception $exception) {
                echo $exception->getMessage();
                exit;
            }
        }
        echo 'task completed.' . PHP_EOL;

        return json_encode($this->parser->getResult());
    }
}