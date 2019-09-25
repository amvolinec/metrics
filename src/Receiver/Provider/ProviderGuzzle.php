<?php

namespace Receiver\Provider {

    use GuzzleHttp\Psr7;
    use GuzzleHttp\Client;

    class ProviderGuzzle implements ProviderInterface
    {

        /**
         *
         * client_id : ju16a6m81mhid5ue1z3v2g0uh
         *
         * @var string
         */
        protected const CLIENT_ID = 'ju16a6m81mhid5ue1z3v2g0uh';

        /**
         *
         * email : your@email.address
         * \
         * @var string
         */
        protected const EMAIL = 'avolinec@gmail.com';

        /**
         *  name : Your Name
         *
         * @var string
         */
        protected const NAME = 'Aleksandr';

        /**
         * Base url of supermetrics api register
         *
         * @var string
         */
        protected const POST_PATH = 'https://api.supermetrics.com/assignment/register';

        /**
         * @return false|string
         */

        /**
         * Base url of supermetrics api posts
         *
         * @var string
         */
        protected const GET_POSTS_PATH = 'https://api.supermetrics.com/assignment/posts';

        protected $client;

        protected $token = false;

        public function __construct()
        {
            $this->client = new Client();
        }

        /**
         * @return bool|false|string
         */
        public function getToken()
        {
            try {
                $response = $this->client->request('POST', self::POST_PATH, array(
                    'form_params' => array(
                        'client_id' => self::CLIENT_ID,
                        'email' => self::EMAIL,
                        'name' => self::NAME
                    ),
                ));

                if (200 === $response->getStatusCode()) {
                    $result_array = json_decode($response->getBody()->getContents(), true);

                    if (isset($result_array['data']['sl_token'])) {
                        $this->token = $result_array['data']['sl_token'];
                        return $this->token;
                    } else {
                        $this->token = false;
                        throw new \RuntimeException('Token not received');
                    }

                } else {
                    throw new \RuntimeException('Connection error', $response->getStatusCode());
                }

            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                $this->throwGuzzException($e);
            }
        }

        /**
         * @param int $page
         * @param bool $token
         * @return array
         */
        public function getData($page = 1, $token = false)
        {
            if ($token !== false) {
                $this->token = $token;
            }

            if (!$token && !$this->token) {
                $this->getToken();
            }

            try {
                $response = $this->client->request('GET', self::GET_POSTS_PATH, array(
                    'query' => array(
                        'sl_token' => $this->token,
                        'page' => $page
                    )
                ));

                if (200 !== $response->getStatusCode()) {
                    throw new \RuntimeException('Connection error', $response->getStatusCode());
                }

                return json_decode($response->getBody()->getContents(), true);

            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                $this->throwGuzzException($e);
            }
        }

        /**
         * @param $e
         */
        private function throwGuzzException($e): void
        {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
            throw new \RuntimeException($e->getMessage());
        }
    }
}