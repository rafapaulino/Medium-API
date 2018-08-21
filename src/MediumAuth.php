<?php
namespace Medium;
use Medium\MediumRequest;

class MediumAuth extends MediumRequest
{
    private $_token;
    private $_params;
    private $_request;
    
    public function __construct($code, $client, $secret, $redirect)
    {
        parent::__construct();
        $this->_token = array();

        $this->_params = array(
            'code'          => $code,
            'client_id'     => $client,
            'client_secret' => $secret,          
            'redirect_uri'  => $redirect,           
            'grant_type'    => 'authorization_code'
        );

        $this->_request = 'https://api.medium.com/v1/tokens';
    }

    public function getToken(): array
    {
        return $this->send(
            $this->_request, 
            $this->_params,
            array(
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json',
                'Accept-Charset: utf-8',
            )
        );
    }

    public function refreshToken($refreshToken): array
    {
        $this->_params['refresh_token'] = $refreshToken;   
        $this->_params['grant_type'] = 'refresh_token';

        return $this->send(
            $this->_request, 
            $this->_params,
            array(
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json',
                'Accept-Charset: utf-8',
            )
        );
    }
}