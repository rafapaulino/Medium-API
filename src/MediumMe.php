<?php

namespace Medium;
use Medium\MediumRequest;

class MediumMe extends MediumRequest
{
    private $_token;

    public function __construct($token)
    {
        parent::__construct();
        $this->_token = $token;
    }

    public function getUser(): array
    {
        return $this->send(
            'https://api.medium.com/v1/me', 
            array(),
            array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Accept-Charset: utf-8',
                'Authorization: Bearer ' . $this->_token
            )
        );
    }
}