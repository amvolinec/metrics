<?php

namespace Receiver\Provider;

interface ProviderInterface
{
    /**
     * @return false|string
     */
    public function getToken();

    /**
     * @param int $page (from 1 to 10)
     * @param bool $token
     * @return mixed
     */
    public function getData($page = 1, $token = false);
}